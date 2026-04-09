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
            $_SESSION['error'] = 'Preencha todos os campos antes de adicionar ao carrinho.';
            header("Location: index.php");
            exit();
        }

        $existingOrderItem = $this->existingOrderItem($productCode);
        $product = $this->productController->getProductByCode($productCode);
        $taxPercent = $this->productController->getTaxByProductCode($productCode);
        $price = $product['price'];
        $tax = $price * ($taxPercent / 100);

        if ($existingOrderItem) {
            if ($product['amount'] < $amount) {
                $_SESSION['error'] = "Estoque insuficiente. Disponível: {$product['amount']}.";
                header("Location: index.php");
                exit();
            }
            $newAmount = $existingOrderItem['amount'] + $amount;
            $newPrice = $existingOrderItem['price'] + ($price * $amount);
            $newTax = $existingOrderItem['tax'] + ($tax * $amount);

            $sql = "UPDATE order_item SET amount = ?, price = ?, tax = ? WHERE code = ?";
            $this->OrderItem->getPDO()->prepare($sql)->execute([$newAmount, $newPrice, $newTax, $existingOrderItem['code']]);

            $sql = "UPDATE products SET amount = amount - ? WHERE code = ?";
            $this->OrderItem->getPDO()->prepare($sql)->execute([$amount, $productCode]);

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
