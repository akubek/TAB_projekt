<?php
class ProductManager {
    private $pdo;

    // connect to database PHP data object
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // get all products with thier categories
    public function getAllProducts() {
        $sql = "
            SELECT p.id, p.name, p.base_price, c.name as category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
        ";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>