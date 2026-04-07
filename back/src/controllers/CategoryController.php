<?php
require_once 'classes/CategoryClass.php';
require_once 'ProductController.php';
class CategoryController
{
    private $category;
    private $productController;
    public function __construct($myPDO)
    {
        $this->category = new Category($myPDO);
        $this->productController = new ProductController($myPDO);
    }
    public function indexCategories()
    {
        return $this->category->getCategories();
    }
    public function createCategory($category, $tax)
    {
        if (empty($category) || empty($tax)) {
            echo "<script>alert('Preencha todos os campos.');</script>";
            return;
        }
        if (!is_numeric($tax) || $tax < 0) {
            echo "<script>alert('O campo de imposto deve ser um número positivo.');</script>";
            return;
        }
        if (strlen($category) > 30) {
            echo "<script>alert('O nome da categoria deve ter no máximo 30 caracteres.');</script>";
            return;
        }
        if ($tax > 100) {
            echo "<script>alert('O valor do imposto é muito grande.');</script>";
            return;
        }
        if ($this->existCategory($category)) {
            echo "<script>alert('Essa categoria já existe.');</script>";
            return;
        }
        $this->category->createCategory($category, $tax);
    }
    public function deleteCategory($code)
    {
        foreach ($this->productController->indexProducts() as $product) {
            if ($code == $product['category_code']) {
                echo "<script>alert('Essa categoria não pode ser deletada, pois existem produtos associados a ela.');</script>";
                return;
            } else {
                $this->category->deleteCategory($code);
            }
        }
    }
    public function existCategory($category)
    {
        foreach ($this->category->getCategories() as $cat) {
            if (strtolower(trim($cat['name'])) == strtolower(trim($category))) {
                return true;
            }
        }
    }
}
