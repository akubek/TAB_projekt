<?php
class CartController
{
    private $productManager;

    public function __construct($productManager)
    {
        $this->productManager = $productManager;
    }

    public function show()
    {
        $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];
        $items = [];
        $totalPrice = 0;
        $colorsDict = require BASE_PATH . '/config/colors.php';

        if (!empty($cart)) {
            $variantIds = array_keys($cart);
            $variants = $this->productManager->getVariantsWithProductInfo($variantIds);

            foreach ($variants as $v) {
                $qty = $cart[$v['variant_id']];
                $unitPrice = $v['base_price'] + $v['price_modifier'];
                $subtotal = $unitPrice * $qty;
                $rawAttributes = json_decode($v['attributes'], true);
                $formattedAttributes = [];

                if (is_array($rawAttributes)) {
                    foreach ($rawAttributes as $key => $value) {
                        if ($key === 'color') {
                            $friendlyColorName = $colorsDict[$value]['name'] ?? $value;
                            $formattedAttributes['Kolor'] = $friendlyColorName;
                        } elseif ($key === 'size') {
                            $formattedAttributes['Rozmiar'] = $value;
                        } else {
                            $formattedAttributes[ucfirst($key)] = $value;
                        }
                    }
                }

                $items[] = [
                    'variant_id' => $v['variant_id'],
                    'product_id' => $v['product_id'],
                    'name' => $v['product_name'],
                    'attributes' => $formattedAttributes,
                    'image' => json_decode($v['images'], true)[0] ?? 'https://placehold.co/100x100',
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                    'stock' => $v['stock_quantity']
                ];
                $totalPrice += $subtotal;
            }
        }
        renderView('cart', [
            'cart' => $cart,
            'items' => $items,
            'totalPrice' => $totalPrice
        ]);
    }
}
