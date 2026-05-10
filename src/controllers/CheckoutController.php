<?php
// controllers/CheckoutController.php

class CheckoutController
{
    private $orderManager;
    private $cartManager;
    private $userManager;

    public function __construct($orderManager, $cartManager, $userManager)
    {
        $this->orderManager = $orderManager;
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
                // created guest or user found in db by email
                $finalUserId = null;

                if (isset($_SESSION['user_id'])) {
                    // Scenariusz A: Zalogowany
                    $finalUserId = $_SESSION['user_id'];
                } else {
                    // Scenariusz B: Gość
                    $existingUser = $this->userManager->getUserByEmail($finalEmail);

                    if ($existingUser) {
                        $finalUserId = $existingUser['id'];
                    } else {
                        // create guest account (shadow account) if email was not found in database
                        $finalUserId = $this->userManager->createGuestUser(
                            $finalEmail,
                            $shippingData['first_name'],
                            $shippingData['last_name'],
                            $shippingData['phone']
                        );
                    }
                }

                //create order 
                $orderId = $this->orderManager->createOrder(
                    $finalUserId,
                    $currentDbTotal,
                    $deliveryMethod,
                    $paymentMethod,
                    $shippingData,
                    $summary['items']
                );

                // success - save last order to display to user
                $_SESSION['last_order_id'] = $orderId;
                unset($_SESSION['processing_order_time']);
                unset($_SESSION['checkout_expected_total']);
                setcookie('cart', '', time() - 3600, '/');

                header("Location: index.php?page=checkout_success");
                exit;
            } catch (PriceChangedException $e) {
                error_log("Błąd kasy: " . $e->getMessage());
                unset($_SESSION['processing_order_time']);
                $_SESSION['flash_error'] = $e->getMessage() . " Przepraszamy, prosimy o ponowną weryfikację koszyka.";
                header("Location: index.php?page=cart");
                exit;
            } catch (ProductUnavailableException $e) {
                error_log("Błąd kasy: " . $e->getMessage());
                unset($_SESSION['processing_order_time']);
                $_SESSION['flash_error'] = $e->getMessage() . " Prosimy o usunięcie niedostępnych produktów z koszyka przed kontynuacją.";
                header("Location: index.php?page=cart");
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
        // Pobieramy ID zamówienia z sesji (ustawione po udanym zapisie)
        $orderId = $_SESSION['last_order_id'] ?? null;

        // Jeśli ktoś wpisze adres z palca, a nie ma przypisanego zamówienia -> na stronę główną
        if (!$orderId) {
            header("Location: index.php");
            exit;
        }

        // Pobieramy świeże dane z bazy za pomocą OrderManagera
        $orderData = $this->orderManager->getOrderSummary($orderId);

        // Jeśli zamówienie z jakiegoś powodu zniknęło z bazy
        if (!$orderData) {
            unset($_SESSION['last_order_id']); // Sprzątamy osierocone ID
            header("Location: index.php");
            exit;
        }

        // UWAGA: Świadomie NIE robimy tutaj unset($_SESSION['last_order_id']); 
        // Pozwala to użytkownikowi na odświeżenie strony (F5) i spokojne skopiowanie numeru zamówienia.
        // Zmienna zniknie automatycznie po zamknięciu przeglądarki lub wylogowaniu.

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
