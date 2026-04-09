<?php
require_once 'conn.php';
class Category {
    private $myPDO;
    public function __construct($myPDO){
        $this->myPDO = $myPDO;
    }
    public function createCategory($category, $tax){
        $display_code = $this->getNextDisplayCode();
        $sql = "INSERT INTO categories (display_code, name, tax) VALUES (?, ?, ?)";
        $this->myPDO->prepare($sql)->execute([$display_code, $category, $tax]);
        header("Location: category.php");
        exit();
    }
    public function  getCategories(){
        $sql = "SELECT * FROM categories ORDER BY display_code ASC";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNextDisplayCode(){
        $sql =  "SELECT MAX(display_code) FROM categories";
        $statement = $this->myPDO->query($sql);
        $max = $statement->fetchColumn();
        return $max ? $max + 1 : 1;
    }
    public function deleteCategory($code){
        $sql = "DELETE FROM categories WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$code]);
        header("Location: category.php");
        exit();
    }
}; 
