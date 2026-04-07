<?php
require_once 'conn.php';
require_once 'controllers/OrdersController.php';

$ordersController = new OrdersController($myPDO);
$ordersHistory = $ordersController->indexOrdersHistory();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/history.css">
    <title>Suite Store</title>
</head>

<body>
    <nav class="menu">
        <ul>
            <li><a href="index.html">
                    <h1>Suite Store</h1>
                </a></li>
            <div class="links">
                <li><a href="products.html">Products</a></li>
                <li><a href="categories.html">Categories</a></li>
                <li><a href="history.html">History</a></li>
            </div>
        </ul>
    </nav>
    <div class="container">
        <div class="tableHistory">
            <table>
                <tr>
                    <th class="thCode">Code</th>
                    <th id="line1" class="thTax">Tax</th>
                    <th id="line1" class="thTotal">Total</th>
                    <th id="line1" class="thActions">Actions</th>
                </tr>
                <tbody id="table">
                    <?php foreach ($ordersHistory as $order): ?>
                        <tr class="product1">
                            <td class="tdCode"><?= $order['code'] ?></td>
                            <td class="tdTax"><?= $order['tax'] ?></td>
                            <td class="tdTotal"><?= $order['total'] ?></td>
                            <td class="tdButton1"><a href="detail.php?code=<?= $order['code'] ?>"><button class="delete1" data-code="<?= $order['code'] ?>">View Details</button></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="scripts/history.js"></script>
</body>

</html>