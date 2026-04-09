<?php
require_once 'classes/ProductClass.php';
require_once 'controllers/CategoryController.php';
class ProductController {
    private $product;
    private $categoryController;
    private $myPDO;
    public function __construct($myPDO) {
        $this->product = new Product($myPDO);
        $this->categoryController = new CategoryController($myPDO);
        $this->myPDO = $myPDO;
    }
    public function indexProducts(){
        return $this->product->getProducts();
    }
    public function createProduct($name, $amount, $price, $category) {
        if (!preg_match('/^[a-zA-ZÀ-ÿ][a-zA-ZÀ-ÿ0-9\s]*$/', $name)){
            $_SESSION['error'] = 'O primeiro caractere precisa obrigatoriamente ser uma letra.';
            header("Location: product.php");
            exit();
        }
        if ($amount > 100000) {
            $_SESSION['error'] = 'A quantidade do produto deve ser de no máximo 100000 unidades';
            header('Location: product.php');
            exit();
        } 
        if (empty($name) || empty($amount) || empty($price) || empty($category)) {
            $_SESSION['error'] = 'Preencha todos os campos possíveis.';
            header("Location: product.php");
            exit();
        }
        if (!is_numeric($amount) || $amount < 0) {
            $_SESSION['error'] = 'O campo de quantidade deve ser um número positivo';
            header("Location: product.php");
            exit();
        }
        if (!is_numeric($price) || $price < 0) {
            $_SESSION['error'] = 'O campo de preço deve ser um número positivo';
            header("Location: product.php");
            exit();
        }
        if (strlen($name) > 30) {
            $_SESSION['error'] = 'O nome do produto deve ter no mínimo 30 caracteres.';
            header("Location: product.php");
            exit();
        }
        if ($this->existProduct($name)) {
            $_SESSION['error'] = 'Esse produto já existe.';
            header("Location: product.php");
            exit();
        }
        $this->product->createProduct($name, $amount, $price, $category);
    }
    public function deleteProduct($code) {
        $sql = "SELECT * FROM order_item WHERE product_code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$code]);
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($categories)){
            $_SESSION['error'] = 'Esse produto não pode ser deletado pois já está associado a um carrinho ou compra';
            header("Location: product.php");
            exit();
        }
        $this->product->deleteProduct($code);

    }
    public function existProduct($name)
    {
        $normalized = strtolower(preg_replace('/\s+/', ' ', trim($name)));
        foreach ($this->product->getProducts() as $prod) {
        $existingName = strtolower(preg_replace('/\s+/', ' ', trim($prod['name'])));
            if ($existingName == $normalized) {
                return true;
            }
        }
    }
    public function getTaxByProductCode($code) {
        $products = $this->indexProducts();
        $categoryController = $this->categoryController->indexCategories();
        foreach($products as $product){
            if($product['code'] == $code){
                foreach($categoryController as $category){
                    if($category['code'] == $product['category_code']){
                        return $category['tax'];
                    }
                }
            }
        }
    }
    public function getProductByCode($code) {
        $products = $this->indexProducts();
        foreach($products as $product){
            if($product['code'] == $code){
                return $product;
            }
        }
    }
};