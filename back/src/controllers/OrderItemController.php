<?php
require_once 'conn.php';
require_once 'classes/OrderItemClass.php';
require_once 'controllers/ProductController.php';
class OrderItemController
{
    private $OrderItem;
    private $productController;
    public function __construct($myPDO)
    {
        $this->OrderItem = new OrderItem($myPDO);
        $this->productController = new ProductController($myPDO);
    }
    public function getPDO()
    {
        return $this->OrderItem->getPDO();
    }
    public function indexOrderItem()
    {
        return $this->OrderItem->getOrders();
    }
    public function existingOrderItem($productCode)
    {
        $sql = "SELECT * FROM order_item WHERE product_code = ? AND order_code IS NULL";
        $statement = $this->OrderItem->getPDO()->prepare($sql);
        $statement->execute([$productCode]);
        $existingOrderItem = $statement->fetch(PDO::FETCH_ASSOC);
        return $existingOrderItem;
    }
    public function createOrderItem($productCode, $amount)
    {
        if (empty($productCode) || empty($amount)) {
            echo "<script>alert('Preencha todos os campos antes de adicionar ao carrinho.');</script>";
            return;
        }
        $existingOrderItem = $this->existingOrderItem($productCode);
        $product = $this->productController->getProductByCode($productCode);
        $taxPercent = $this->productController->getTaxByProductCode($productCode);
        $price = $product['price'];
        $tax = $price * ($taxPercent / 100);
        if ($existingOrderItem) {
            $amount = $existingOrderItem['amount'] + $amount;
            $price = $existingOrderItem['price'] + $price;
            $tax = $existingOrderItem['tax'] + $tax;
            $sql = "UPDATE order_item SET amount = ?, price = ?, tax = ? WHERE code = ?";
            $this->OrderItem->getPDO()->prepare($sql)->execute([$amount, $price, $tax, $existingOrderItem['code']]);
            header("Location: index.php");
            exit();
        }
        $this->OrderItem->createOrder($productCode, $amount);
    }
    public function deleteOrderItem($code)
    {
        $this->OrderItem->deleteOrderItem($code);
    }
    public function finishOrder()
    {
        $this->OrderItem->finishOrder();
    }
    public function calculateTotalAndTax()
    {
        return $this->OrderItem->calculateTotalAndTax();
    }
}
