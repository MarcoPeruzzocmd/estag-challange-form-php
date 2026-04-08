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
        if (empty($name) || empty($amount) || empty($price) || empty($category)) {
            echo"<script>alert('Preencha todos os campos.');</script>";
            return;
        }
        if (!is_numeric($amount) || $amount < 0) {
            echo"<script>alert('O campo de quantidade deve ser um número positivo.');</script>";
            return;
        }
        if (!is_numeric($price) || $price < 0) {
            echo"<script>alert('O campo de preço deve ser um número positivo.');</script>";
            return;
        }
        if (strlen($name) > 30) {
            echo"<script>alert('O nome do produto deve ter no máximo 30 caracteres.');</script>";
            return;
        }
        if ($this->existProduct($name)) {
            echo"<script>alert('Esse produto já existe.');</script>";
            return;
        }
        $this->product->createProduct($name, $amount, $price, $category);
    }
    public function deleteProduct($code) {
        $sql = "SELECT * FROM order_item WHERE product_code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$code]);
        $categories = $statement->fetchAll(PDO::FETCH_ASSOC);

        if(!empty($categories)){
            echo "<script>alert('Esse produto não pode ser deletado, pois esta associado a um carrinho ou compra.');</script>";
            return;
        }
        $this->product->deleteProduct($code);

    }
    public function existProduct($name)
    {
        foreach ($this->product->getProducts() as $prod) {
            if (strtolower(trim($prod['name'])) == strtolower(trim($name))) {
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