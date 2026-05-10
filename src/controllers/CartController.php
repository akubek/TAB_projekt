<?php
class CartController
{
    private $cartManager;

    public function __construct($cartManager)
    {
        $this->cartManager = $cartManager;
    }

    public function show()
    {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

        $summary = $this->cartManager->getCartSummary($cart);
        $errorMessage = $_SESSION['flash_error'] ?? '';
        unset($_SESSION['flash_error']);

        renderView('cart', [
            'cart'       => $cart,
            'items'      => $summary['items'],
            'totalPrice' => $summary['totalPrice'],
            'errorMessage' => $errorMessage
        ]);
    }
}
