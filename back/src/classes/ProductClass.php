<?php
class Product {
    private $myPDO;
    public function __construct($myPDO)
    {
        $this->myPDO = $myPDO;
    }
    public function getNextDisplayCode(){
        $sql =  "SELECT MAX(display_code) FROM products";
        $statement = $this->myPDO->query($sql);
        $max = $statement->fetchColumn();
        return $max ? $max + 1 : 1;
    }
    public function createProduct($name, $amount, $price, $category){
        $display_code = $this->getNextDisplayCode();
        $sql = "INSERT INTO products (display_code, name, amount, price, category_code) VALUES (?,?,?,?,?)";
        $this->myPDO->prepare($sql)->execute([$display_code, $name, $amount, $price, $category]);
        header("Location: product.php");
        exit();
    }
    public function getProducts(){
        $sql = "SELECT * FROM products ORDER BY display_code ASC";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductsSelect(){
        $sql = "SELECT * FROM products WHERE amount > 0 ORDER BY display_code ASC";
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