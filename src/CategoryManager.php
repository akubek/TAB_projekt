<?php
class CategoryManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Pobiera główne kategorie (te, które nie mają rodzica, np. "Odzież")
    public function getRootCategories() {
        $stmt = $this->pdo->query("SELECT * FROM categories WHERE parent_id IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pobiera podkategorie dla konkretnego rodzica
    public function getSubcategories($parentId) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE parent_id = :parent_id");
        $stmt->bindValue(':parent_id', $parentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Pobiera dane konkretnej kategorii (żeby wyświetlić jej nazwę w nagłówku)
    public function getCategoryById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>