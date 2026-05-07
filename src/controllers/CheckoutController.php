<?php
// controllers/CheckoutController.php

class CheckoutController
{
    public function __construct() {}

    public function start()
    {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        if (empty($cart)) {
            header('Location: index.php?page=cart');
            exit;
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?page=checkout_form');
            exit;
        }

        renderView('checkout_auth_gate');
    }

    public function showForm()
    {
        renderView('checkout_form', ['title' => 'Dane Dostawy']);
    }
}
