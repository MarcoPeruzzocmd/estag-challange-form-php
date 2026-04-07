<?php
class Product {
    private $myPDO;
    public function __construct($myPDO)
    {
        $this->myPDO = $myPDO;
    }
    public function createProduct($name, $amount, $price, $category){
        $sql = "INSERT INTO products (name, amount, price, category_code) VALUES (?,?,?,?)";
        $this->myPDO->prepare($sql)->execute([$name, $amount, $price, $category]);
        header("Location: product.php");
        exit();
    }
    public function getProducts(){
        $sql = "SELECT * FROM products";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteProduct($code){
        $sql = "DELETE FROM products WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$code]);
        header("Location: product.php");
        exit();
    }
};