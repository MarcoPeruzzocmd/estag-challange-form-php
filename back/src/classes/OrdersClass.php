<?php
require_once 'conn.php';
class Orders {
    private $myPDO;
    public function __construct($myPDO)
    {
        $this->myPDO = $myPDO;
    }
    public function getOrdersHistory(){
        $sql = "SELECT * FROM orders";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } 
}
    