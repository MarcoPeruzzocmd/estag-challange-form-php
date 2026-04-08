<?php
require_once 'conn.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/OrderItemController.php';
require_once 'controllers/CategoryController.php';

$productController = new ProductController($myPDO);
$categoryController = new CategoryController($myPDO);
$products = $productController->indexProducts();
$categories = $categoryController->indexCategories();
$orderItemController = new OrderItemController($myPDO);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        if (empty($_POST['product']) || empty($_POST['amount'])) {
            echo "<script>alert('Preencha todos os campos antes de adicionar ao carrinho.');</script>";
        }
        else if ($_POST['amount'] <= 0) {
            echo "<script>alert('O campo de quantidade deve ser um número positivo.');</script>";
        }
        else {
            $orderItemController->createOrderItem($_POST['product'] ?? '', $_POST['amount'] ?? '');
        }
    }

    if (isset($_POST['delete'])) {
        $orderItemController->deleteOrderItem($_POST['code']);
    }
    if (isset($_POST['finish'])) {
        $orderItemController->finishOrder($_POST['finish']);
    }
}
$ordersItem = $orderItemController->indexOrderItem();
$totalsValues = $orderItemController->calculateTotalAndTax();
?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/index.css" />
    <title>Suite Store</title>
</head>

<body>
    <nav class="menu">
        <ul>
            <li>
                <a href="index.php">
                    <h1>Suite Store</h1>
                </a>
            </li>
            <div class="links">
                <li><a href="product.php">Products</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="history.php">History</a></li>
            </div>
        </ul>
    </nav>
    <div class="container">
        <form action="" method="post" class="fCart">
            <div class="inputCima">
                <select id="select" name="product" placeholder="Product">
                    <?php
                    if ((!isset($products)) || count($products) <= 0) {
                        echo "<option value='' id='optSelecione' selected disabled>Não existem produtos</option>";
                    } else {
                        echo "<option value='' disabled selected>Selecione um produto</option>";
                    }
                    foreach ($products as $product) {
                        echo "<option value='{$product['code']}'>{$product['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="inputBaixo">
                <input type="number" name="amount" id="amount" placeholder="Amount" class="amountInput" />
                <input type="text" name="tax" id="tax" disabled placeholder="Tax value" class="taxInput" />
                <input type="text" name="price" id="price" disabled placeholder="Price" class="priceInput" />
            </div>

            <button name="add" type="submit">Add product</button>
        </form>
        <form
            action=""
            method="post"
            class="fProduct"
            style="border-left: 1px solid rgba(0, 0, 0, 0.5)">
            <div class="tableCart" style="margin-left: 20px">
                <table>
                    <tr>
                        <th id="code">Code</th>
                        <th class="thProduct">Product</th>
                        <th id="line1" class="thPrice">Price</th>
                        <th id="line1" class="thAmount">Amount</th>
                        <th id="line1" class="thTax">Tax</th>
                        <th id="line2" class="thTotal">Total</th>
                        <th class="thActions">Actions</th>
                    </tr>
                    <tbody id="table">
                        <?php foreach ($ordersItem as $orderItem): ?>
                            <tr class="product1">
                                <td class="tdCode"><?= $orderItem['code'] ?></td>
                                <td class="tdProduct">
                                    <?php
                                    foreach ($products as $product) {
                                        if ($product['code'] == $orderItem['product_code']) {
                                            echo $product['name'];
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="tdPrice"><?= $orderItem['price'] ?></td>
                                <td class="tdAmount"><?= $orderItem['amount'] ?></td>
                                <td class="tdTax"><?= $orderItem['tax'] ?></td>
                                <td class="tdTotal"><?= $orderItem['total'] ?></td>
                                <td class="tdButton1">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="code" value="<?= $orderItem['code'] ?>">
                                        <input type="submit" name="delete" class="delete1" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="finalCart">
                    <div class="bottomCart">
                        <div class="pTax">
                            <h5 style="font-size: 17px">Tax:</h5>
                            <p id="textTotalTax" style="font-size: 15px">R$ <?= number_format($totalsValues['totalTax'], 2, ',', '.') ?></p>
                        </div>
                        <div class="pTotal">
                            <h5 style="font-size: 17px">Total:</h5>
                            <p id="textTotal" style="font-size: 15px">R$ <?= number_format($totalsValues['totalPrice'], 2, ',', '.') ?></p>
                        </div>
                    </div>
                    <div class="buttonsCart">
                        <button class="cancel">Cancel</button>
                        <button name="finish" class="finish">Finish</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="scripts/index.js"></script>
</body>

</html>

<script>
    const select = document.getElementById("select");
    const newPrice = document.getElementById("price");
    const tax = document.getElementById("tax");
    const amount = document.getElementById("amount");
    const products = <?php echo json_encode($products); ?>;
    const categories = <?php echo json_encode($categories); ?>;
    select.addEventListener("change", function() {
        const selectedProduct = products.find(product => product.code == Number(this.value));
        const selectedCategory = categories.find(category => category.code == selectedProduct.category_code);
        if (selectedProduct && selectedCategory) {
            newPrice.value = selectedProduct.price;
            tax.value = selectedCategory.tax;
        } else {
            newPrice.value = "";
            tax.value = "";
        }
    });
</script>