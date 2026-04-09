<?php
require_once 'classes/CategoryClass.php';
class CategoryController
{
    private $category;
    private $myPDO;
    public function __construct($myPDO)
    {
        $this->category = new Category($myPDO);
        $this->myPDO = $myPDO;
    }   
    public function indexCategories()
    {
        return $this->category->getCategories();
    }
    public function createCategory($category, $tax)
    {
        if (!preg_match('/^[a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ0-9\s]*$/', $category)){
            $_SESSION['error'] = 'O primeiro caractere precisa obrigatoriamente ser uma letra.';
            header("Location: category.php");
            exit();
        }
        if (empty($category)) {
            $_SESSION['error'] = 'Preencha o campo de categoria';
            header("Location: category.php");
            exit();
        }
        if ($tax === '' || $tax ===  null) {
            $_SESSION['error'] = 'Preencha o campo de taxa';
            header("Location: category.php");
            exit();
        }
        if (!is_numeric($tax) || $tax < 0) {
            $_SESSION['error'] = 'O campo de imposto deve ser um número positivo';
            header("Location: category.php");
            exit();
        }
        if (strlen($category) > 30) {
            $_SESSION['error'] = 'O nome da categoria deve ter no máximo 30 caractéres';
            header("Location: category.php");
            exit();
        }
        if ($tax > 100) {
            $_SESSION['error'] = 'O valor de imposto deve ser de no máximo 100%';
            header("Location: category.php");
            exit();
        }
        if ($this->existCategory($category)) {
            $_SESSION['error'] = 'Essa categoria já existe';
            header("Location: category.php");
            exit();
        }
        $this->category->createCategory($category, $tax);
    }
    public function deleteCategory($code)
    {
        $sql = "SELECT * FROM products WHERE category_code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$code]);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($products)) {
            echo "<script>alert('Essa categoria não pode ser deletada, pois existem produtos associados a ela.');</script>";
            return;
        }
        
        $this->category->deleteCategory($code);
    }
    public function existCategory($category)
    {
        $normalized = strtolower(preg_replace('/\s+/', ' ', trim($category)));
        foreach ($this->category->getCategories() as $cat) {
            $existingName = strtolower(preg_replace('/\s+/', ' ', trim($cat['name'])));
            if ($existingName == $normalized) {
                return true;
            }
        }
    }
}
