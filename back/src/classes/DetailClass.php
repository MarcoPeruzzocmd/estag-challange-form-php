<?php
require_once 'conn.php';
class Detail {
    private $myPDO;
    public function __construct($myPDO){
        $this->myPDO = $myPDO;
    }
    public function viewDetail ($code){
        $sql = "SELECT o.code, o.date, oi.product_code, oi.amount, p.name AS product_name, c.tax
                FROM orders o
                JOIN order_item oi ON o.code = oi.order_code
                JOIN products p ON oi.product_code = p.code
                JOIN categories c ON p.category_code = c.code
                WHERE o.code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$code]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}