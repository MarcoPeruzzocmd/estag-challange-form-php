<?php
require_once 'classes/ProductClass.php';
class ProductController {
    private $product;
    public function __construct($myPDO) {
        $this->product = new Product($myPDO);
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
};