<?php
// controllers/CheckoutController.php

class CheckoutController
{
    private $pdo;
    private $cartManager;

    public function __construct($pdo, $cartManager)
    {
        $this->pdo = $pdo;
        $this->cartManager = $cartManager;
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
                $lockTime = $_SESSION['processing_order_time'];

                // Jeśli od poprzedniej próby minęło mniej niż 15 sekund:
                if (time() - $lockTime < 15) {
                    // To spam lub niecierpliwy użytkownik. 
                    $_SESSION['flash_error'] = "Przetwarzamy Twoje zamówienie. Proszę chwilę poczekać...";
                    header("Location: index.php?page=checkout_form");
                    exit;
                }
            }
            $_SESSION['processing_order_time'] = time();

            try {

                $expectedTotal = $_SESSION['checkout_expected_total'] ?? 0;

                if ($currentDbTotal !== $expectedTotal) {
                    // Cena w bazie uległa zmianie w trakcie trwania sesji!
                    unset($_SESSION['processing_order_time']);
                    $_SESSION['flash_error'] = "Ceny produktów uległy zmianie! Zaktualizowaliśmy Twój koszyk, prosimy o ponowną weryfikację.";
                    header("Location: index.php?page=cart");
                    exit;
                }
                // b) TUTAJ BĘDZIE LOGIKA TRANSAKCJI PDO (ZAPIS DO BAZY)
                // Na razie tylko "łapiemy" dane, żebyś zobaczył, co przyszło.

                $deliveryMethod = $_POST['delivery_method'] ?? '';
                $paymentMethod = $_POST['payment_method'] ?? '';
                $shippingData = $_POST['shipping'] ?? [];

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

                // Po udanym testowym var_dump, zabijamy skrypt, żeby nie renderował widoku pod spodem
                unset($_SESSION['processing_order_time']);
                header("Location: index.php?page=checkout_success");
                exit;
            } catch (Exception $e) {
                // W razie błędu PDO
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

        $errorMessage = $errorMessage ?? '';

        renderView('checkout_form', [
            'errorMessage' => $errorMessage,
            'items' => $summary['items'],
            'totalToPay' => $currentDbTotal
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

    private function requireValidCart(): void
    {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        if (empty($cart)) {
            header('Location: index.php?page=cart');
            exit;
        }
    }
}
