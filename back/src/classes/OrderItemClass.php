<?php
require_once 'controllers/ProductController.php';
class OrderItem
{
    private $myPDO;
    public function __construct($myPDO)
    {
        $this->myPDO = $myPDO;
    }
    public function getPDO()
    {
        return $this->myPDO;
    }
    public function createOrder($productCode, $amount)
    {
        $sql = "SELECT amount, name FROM products WHERE code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$productCode]);
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if ($product['amount'] < $amount) {
            $_SESSION['error'] = "Estoque insuficiente para '{$product['name']}'. Disponível: {$product['amount']}.";
            header("Location: index.php");
            exit();
        }

        $sql = "SELECT price FROM products WHERE code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$productCode]);
        $price = $statement->fetch(PDO::FETCH_ASSOC)['price'] * $amount;

        $sql = "SELECT tax FROM categories WHERE code = (SELECT category_code FROM products WHERE code = ?)";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$productCode]);
        $tax = $price * ($statement->fetch(PDO::FETCH_ASSOC)['tax'] / 100);

        $sql = "INSERT INTO order_item (product_code, amount, price, tax) VALUES (?,?,?,?)";
        $this->myPDO->prepare($sql)->execute([$productCode, $amount, $price, $tax]);

        $this->decrementAmount($productCode, $amount);
        header("Location: index.php");
        exit();
    }
    public function getOrders()
    {
        $sql = "SELECT *, price + tax AS total FROM order_item WHERE order_code IS NULL";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteOrderItem($code)
    {
        $sql = "SELECT product_code, amount FROM order_item WHERE code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$code]);
        $orderItem = $statement->fetch(PDO::FETCH_ASSOC);
        if ($orderItem) {
            $sql = "UPDATE products SET amount = amount + ? WHERE code = ?";
            $this->myPDO->prepare($sql)->execute([$orderItem['amount'], $orderItem['product_code']]);
        }
        $sql = "DELETE FROM order_item WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$code]);
        header("Location: index.php");
        exit();
    }
    public function calculateTotalAndTax()
    {
        $orders = $this->getOrders();
        $totalPrice = 0;
        $totalTax = 0;
        foreach ($orders as $order) {
            $totalTax += $order['tax'];
            $totalPrice += $order['price'];
        }
        return ['totalPrice' => $totalPrice, 'totalTax' => $totalTax];
    }
    public function decrementAmount($productCode, $amount)
    {
        $sql = "UPDATE products SET amount = amount - ? WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$amount, $productCode]);
    }
    public function finishOrder()
    {
        if (empty($this->getOrders())) {
            echo "<script>alert('O carrinho está vazio.');</script>";
            return;
        }
        $sql = "INSERT INTO orders (total, tax, data_compra, hora_compra) VALUES (?, ?, ?, ?) RETURNING code";
        $totals = $this->calculateTotalAndTax();
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$totals['totalPrice'], $totals['totalTax'], date('Y-m-d'), date('H:i:s')]);
        $orderCode = $statement->fetch(PDO::FETCH_ASSOC)['code'];
        $sql = "UPDATE order_item SET order_code = ? WHERE order_code IS NULL";
        $this->myPDO->prepare($sql)->execute([$orderCode]);
        header("Location: history.php");
        exit();
    }
}
