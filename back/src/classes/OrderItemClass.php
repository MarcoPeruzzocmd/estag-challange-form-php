<?php
require_once 'controllers/ProductController.php';
class OrderItem {
    private $myPDO;
    public function __construct($myPDO){
        $this->myPDO = $myPDO;
    }
    public function getPDO(){
        return $this->myPDO;
    }
    public function createOrder ($productCode, $amount){
        $sql = "SELECT amount FROM products WHERE code = ? AND amount < ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$productCode, $amount]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $productController = new ProductController($this->myPDO);
        $productName = $productController->indexProducts();
        foreach ($productName as $products) {
            if ($products['code'] == $productCode) {
                $productName = $products['name'];
                break;
            }
        }
        if ($result){
            echo "<script>alert('Quantidade insuficiente para o produto $productName, você pode comprar  até {$result['amount']}.');</script>";
            return;
        }

        $sql = "SELECT price FROM products WHERE code = ?";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$productCode]);
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        $price = $product['price'] * $amount;

        $sql = "SELECT tax FROM categories WHERE code = (SELECT category_code FROM products WHERE code = ?)";
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$productCode]);
        $category = $statement->fetch(PDO::FETCH_ASSOC);
        $tax = $price * ($category['tax'] / 100);

        $sql = "INSERT INTO order_item (product_code, amount, price, tax) VALUES (?,?,?,?)";
        $this->myPDO->prepare($sql)->execute([$productCode, $amount, $price, $tax]);
        header("Location: index.php");
        exit();
    }
    public function getOrders(){
        $sql = "SELECT *, price + tax AS total FROM order_item WHERE order_code IS NULL";
        $statement = $this->myPDO->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteOrderItem($code){
        $sql = "DELETE FROM order_item WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$code]);
        header("Location: index.php");
        exit(); 
    }
    public function calculateTotalAndTax() {
        $orders=$this->getOrders();
        $totalPrice = 0;
        $totalTax = 0;
        foreach ($orders as $order) {
            $totalTax += $order['tax'];
            $totalPrice += $order['price'];
        }
        return ['totalPrice' => $totalPrice, 'totalTax' => $totalTax];
    }
    public function decrementAmount($productCode, $amount) {
        $sql = "UPDATE products SET amount = amount - ? WHERE code = ?";
        $this->myPDO->prepare($sql)->execute([$amount, $productCode]);
    }
    public function finishOrder(){
        if (empty($this->getOrders())) {
            echo "<script>alert('O carrinho está vazio. Adicione itens antes de finalizar o pedido.');</script>";
            return;
        }

        $sql = "INSERT INTO orders (total, tax, data_compra, hora_compra) VALUES (?, ?, ?, ?) RETURNING code";
        $totals = $this->calculateTotalAndTax();
        $statement = $this->myPDO->prepare($sql);
        $statement->execute([$totals['totalPrice'], $totals['totalTax'], date('Y-m-d'), date('H:i:s')]);

        $order = $statement->fetch(PDO::FETCH_ASSOC);
        $orderCode = $order['code'];

        foreach ($this->getOrders() as $ordersItem) {
            $this->decrementAmount($ordersItem['product_code'], $ordersItem['amount']);
        }

        $sql = "UPDATE order_item SET order_code = ? WHERE order_code IS NULL";
        $this->myPDO->prepare($sql)->execute([$orderCode]);
        header("Location: history.php");
        exit();
        

    }
}
