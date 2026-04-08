<?php
require_once 'conn.php';
class Detail {
    private $myPDO;
    public function __construct($myPDO){
        $this->myPDO = $myPDO;
    }
    public function viewDetail ($code){
        $sql = "SELECT o.code, p.name as product_name, c.name as category_name, oi.amount, p.price, oi.tax, oi.price, o.data_compra, o.hora_compra FROM orders o
        INNER JOIN order_item oi ON oi.order_code = o.code
        INNER JOIN products p ON p.code = oi.product_code
        INNER JOIN categories c ON c.code = p.category_code
        WHERE o.code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$code]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}