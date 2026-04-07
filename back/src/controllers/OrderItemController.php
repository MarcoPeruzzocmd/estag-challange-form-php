<?php 
require_once 'classes/OrderItemClass.php';
class OrderItemController {
    private $OrderItem;
    public function __construct($myPDO)
    {
    $this->OrderItem = new OrderItem($myPDO);
    }
    public function indexOrderItem(){
        return $this->OrderItem->getOrders();
    }
    public function createOrderItem($productCode, $amount){
        $this->OrderItem->createOrder($productCode, $amount);
    }
    public function deleteOrderItem($code){
        $this->OrderItem->deleteOrderItem($code);
    }
    public function finishOrder(){
        $this->OrderItem->finishOrder();
    }
    public function calculateTotalAndTax(){
        return $this->OrderItem->calculateTotalAndTax();
    }
}