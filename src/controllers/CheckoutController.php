<?php
// controllers/CheckoutController.php

class CheckoutController
{
    private $pdo;
    private $cartManager;
    private $userManager;

    public function __construct($pdo, $cartManager, $userManager)
    {
        $this->pdo = $pdo;
        $this->cartManager = $cartManager;
        $this->userManager = $userManager;
    }
    public function start()

    {
        $this->requireValidCart();

        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=checkout_form');
            exit;
        }

        renderView('checkout_auth_gate');
    }

    public function handleCheckout()
    {
        $this->requireValidCart();

        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        $summary = $this->cartManager->getCartSummary($cart);
        $currentDbTotal = $summary['totalPrice'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Timestamp Lock
            if (isset($_SESSION['processing_order_time'])) {
                if (time() - $_SESSION['processing_order_time'] < 15) {
                    $this->redirectWithError("Przetwarzamy Twoje zamówienie. Proszę chwilę poczekać...");
                }
            }
            $_SESSION['processing_order_time'] = time();

            $expectedTotal = $_SESSION['checkout_expected_total'] ?? 0;
            if ($currentDbTotal !== $expectedTotal) {
                $this->redirectWithError("Ceny uległy zmianie! Zaktualizowaliśmy koszyk.", "cart");
            }

            $deliveryMethod = $_POST['delivery_method'] ?? '';
            $paymentMethod = $_POST['payment_method'] ?? '';
            $shippingData = $_POST['shipping'] ?? [];

            // basic sanitization
            foreach ($shippingData as $key => $value) {
                $shippingData[$key] = trim(strip_tags($value));
            }

            // check email validity
            $finalEmail = '';
            if (isset($_SESSION['user_id'])) {
                // logged in - get from database
                $currentUser = $this->userManager->getUserById($_SESSION['user_id']);
                $finalEmail = $currentUser['email'] ?? '';
                unset($shippingData['email']); // Ignorujemy to, co mogło przyjść z frontu
            } else {
                // guest - check e-mail format
                $guestEmail = $shippingData['email'] ?? '';
                if (!filter_var($guestEmail, FILTER_VALIDATE_EMAIL)) {
                    $this->redirectWithError("Podano niepoprawny adres e-mail!");
                }
                $finalEmail = $guestEmail;
            }

            // normlize and validate phone
            $phone = preg_replace('/[^0-9]/', '', $shippingData['phone'] ?? '');

            if (strlen($phone) !== 9) {
                $this->redirectWithError("Podano niepoprawny numer telefonu. Wymagane jest 9 cyfr.");
            }
            $shippingData['phone'] = $phone; // Zapisujemy z powrotem czysty numer do tablicy

            if (empty($shippingData['first_name']) || empty($shippingData['last_name'])) {
                $this->redirectWithError("Imię i nazwisko są wymagane!");
            }

            if ($deliveryMethod === 'courier') {
                if (empty($shippingData['street']) || empty($shippingData['city'])) {
                    $this->redirectWithError("Proszę podać pełny adres (ulica i miasto).");
                }
                if (!preg_match('/^[0-9]{2}-[0-9]{3}$/', $shippingData['zip_code'] ?? '')) {
                    $this->redirectWithError("Niepoprawny format kodu pocztowego (wymagany: XX-XXX).");
                }
            } elseif ($deliveryMethod === 'paczkomat') {
                if (empty($shippingData['paczkomat_code'])) {
                    $this->redirectWithError("Proszę podać kod Paczkomatu.");
                }
            } elseif ($deliveryMethod !== 'pickup') {
                // Jeśli ktoś próbował zhakować radio button i przesłał metodę, której nie znamy:
                $this->redirectWithError("Nieznana metoda dostawy.");
            }

            // TODO LOGIKA TRANSAKCJI PDO (ZAPIS DO BAZY)
            try {

                // Do celów testowych zapisujemy całe dane - todo jeżeli będzie zapis do bazy, zmienić na zapisanie id ostatniego zlozonego zamowienia.
                $_SESSION['last_order_summary'] = [
                    'delivery' => $deliveryMethod,
                    'payment'  => $paymentMethod,
                    'shipping' => $shippingData,
                    'total'    => $currentDbTotal,
                    'items'    => $summary['items'] // Mamy to pod ręką z CartManagera!
                ];
                unset($_SESSION['processing_order_time']);
                unset($_SESSION['checkout_expected_total']);
                setcookie('cart', '', time() - 3600, '/');

                header("Location: index.php?page=checkout_success");
                exit;
            } catch (Exception $e) {
                // W razie błędu PDO TODO - ROLLBACK!!!
                error_log("Błąd kasy: " . $e->getMessage());
                $errorMessage = "Wystąpił problem z systemem. Spróbuj ponownie.";
            } finally {
                // c) Niezależnie co się stało, zdejmujemy blokadę podwójnego kliknięcia!
                unset($_SESSION['processing_order_time']);
            }
        }

        // ==========================================
        // 3. OBSŁUGA ŻĄDANIA GET (Zwykłe wejście na stronę - renderowanie formularza)
        // ==========================================
        unset($_SESSION['processing_order_time']);

        $_SESSION['checkout_expected_total'] = $currentDbTotal;

        $errorMessage = $_SESSION['flash_error'] ?? '';
        unset($_SESSION['flash_error']);

        $currentUser = null;
        if (isset($_SESSION['user_id'])) {
            $currentUser = $this->userManager->getUserById($_SESSION['user_id']);
        }

        renderView('checkout_form', [
            'errorMessage' => $errorMessage,
            'items' => $summary['items'],
            'totalToPay' => $currentDbTotal,
            'currentUser' => $currentUser
        ]);
    }

    public function showSuccess()
    {
        // Pobieramy dane z sesji
        $orderData = $_SESSION['last_order_summary'] ?? null;

        // Jeśli ktoś wpisze adres z palca, a nie ma danych w sesji -> na stronę główną
        if (!$orderData) {
            header("Location: index.php");
            exit;
        }

        // CZYŚCIMY SESJĘ! Dzięki temu strona sukcesu wyświetli się tylko raz. 
        // Przy odświeżeniu (F5) użytkownik wróci na stronę główną (dzięki if wyżej).
        unset($_SESSION['last_order_summary']);

        renderView('checkout_success', [
            'order' => $orderData
        ]);
    }

    private function redirectWithError(string $message, string $page = 'checkout_form'): void
    {
        unset($_SESSION['processing_order_time']);

        // Opcjonalnie: Tutaj w przyszłości możesz zapisywać do sesji $_POST['shipping'], 
        // żeby zwrócić klientowi wpisane przez niego dane, aby nie musiał wypełniać formularza od nowa!

        $_SESSION['flash_error'] = $message;
        header("Location: index.php?page=" . $page);
        exit;
    }

    private function requireValidCart(): void
    {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        if (empty($cart)) {
            header('Location: index.php?page=cart');
            exit;
        }
    }
}
