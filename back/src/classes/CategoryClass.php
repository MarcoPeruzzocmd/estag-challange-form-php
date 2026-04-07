<?php
require_once 'conn.php';
class Category {
    private $myPDO;
    public function __construct($myPDO){
        $this->myPDO = $myPDO;
    }
    public function createCategory($category, $tax){
        $sql = "INSERT INTO categories (name, tax) VALUES (?,?)";
        $this->myPDO->prepare($sql)->execute([$category, $tax]);
        header("Location: category.php");
        exit();
    }
    public function  getCategories(){
        $sql = "SELECT * FROM categories";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteCategory($code){
        $sql = "DELETE FROM categories WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$code]);
        header("Location: category.php");
        exit();
    }
}; 
