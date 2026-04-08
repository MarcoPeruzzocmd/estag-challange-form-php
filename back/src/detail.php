<?php
require_once 'conn.php';
require_once 'controllers/DetailController.php';
$detailController = new DetailController($myPDO);
$code = $_GET['code'];
$details = $detailController->viewDetail($code);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/detail.css">
    <title>Suite Store</title>
</head>

<body>
    <nav>
        <a href="history.php" class="back"><img src="img/arrow_back.svg" alt="" style="width: 50px;"
                height="50px"></a>
        <h1>Suite Store</h1>
    </nav>
    <div class="container">
        <div class="tableBuy">
            <table>
                <tr>
                    <th id="line1">Code sale</th>
                    <th id="line1">Product</th>
                    <th id="line1">Category</th>
                    <th id="line1">Amount</th>
                    <th id="line1">Unit Price</th>
                    <th id="line1">Tax</th>
                    <th id="line1">Total</th>
                    <th id="line1">Date</th>
                    <th id="line2">Hour</th>
                </tr>
                <tbody id="table">
                    <?php foreach ($details as $detail) { ?>
                        <tr>
                            <td id="line1"><?php echo $detail['code']; ?></td>
                            <td id="line1"><?php echo $detail['product_name']; ?></td>
                            <td id="line1"><?php echo $detail['category_name']; ?></td>
                            <td id="line1"><?php echo $detail['amount']; ?></td>
                            <td id="line1"><?php echo $detail['price']; ?></td>
                            <td id="line1"><?php echo $detail['tax']; ?></td>
                            <td id="line1"><?php echo number_format($detail['price'] + $detail['tax'], 2, ',', '.'); ?></td>
                            <td id="line1"><?php echo $detail['data_compra']; ?></td>
                            <td id="line1"><?php echo $detail['hora_compra']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="scripts/detail.js"></script>
</body>

</html>