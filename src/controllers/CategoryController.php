<?php
class CategoryController
{
    private $categoryManager;
    private $productManager;

    public function __construct($categoryManager, $productManager)
    {
        $this->categoryManager = $categoryManager;
        $this->productManager = $productManager;
    }

    public function show($categoryId)
    {
        if ($categoryId) {
            $currentCategory = $this->categoryManager->getCategoryById($categoryId);
            $categoryPath = $this->categoryManager->getCategoryPath($categoryId);
            $subcategories = $this->categoryManager->getSubCategories($categoryId);

            $breadcrumbs = [
                ['name' => 'Strona Główna', 'url' => 'index.php?page=home']
            ];

            if (!empty($categoryPath)) {
                foreach ($categoryPath as $index => $step) {
                    $isLast = ($index === count($categoryPath) - 1); //check if last elsement

                    $breadcrumbs[] = [
                        'name' => $step['name'],
                        // if last element don't add link (this is the element page)
                        'url'  => $isLast ? null : 'index.php?page=category&id=' . $step['id']
                    ];
                }
            }

            // if this category has subcategories display them
            // otherwise display products list
            if (!empty($subcategories)) {
                $sort = $_GET['sort'] ?? 'newest';
                $products = $this->productManager->getProductsByCategory($categoryId, 9, $sort);
                renderView('category_list', [
                    'currentCategory' => $currentCategory,
                    'breadcrumbs'     => $breadcrumbs,
                    'subcategories'   => $subcategories,
                    'products'        => $products,
                    'sort'            => $sort
                ]);
            } else {
                $sort = $_GET['sort'] ?? 'newest';
                $products = $this->productManager->getProductsByCategory($categoryId, null, $sort);
                renderView('product_list', [
                    'currentCategory' => $currentCategory,
                    'breadcrumbs'     => $breadcrumbs,
                    'products'        => $products,
                    'sort'            => $sort
                ]);
            }
        } else {
            echo "<div class='alert alert-danger'>Brak ID kategorii w adresie URL.</div>";
        }
    }
}
