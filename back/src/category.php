<?php
require_once 'conn.php';
require_once 'controllers/CategoryController.php';
$categoryController = new CategoryController($myPDO);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $categoryController->createCategory($_POST['category'], $_POST['tax']);
    } elseif (isset($_POST['delete'])) {
        $categoryController->deleteCategory($_POST['code']);
    }
}
$categories = $categoryController->indexCategories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/category.css">
    <title>Suite Store</title>
</head>

<body>
    <nav class="menu">
        <ul>
            <li><a href="index.php">
                    <h1>Suite Store</h1>
                </a></li>
            <div class="links">
                <li><a href="product.php">Products</a></li>
                <li><a href="category.php">Categories</a></li>
                <li><a href="history.php">History</a></li>
            </div>
        </ul>
    </nav>
    <div class="container">
        <form id="form" class="fProduct" method="POST">
            <div class="addProduct" id="addProduct">
                <input maxlength="30" class="categoriesInput" placeholder="Categories" type="text" name="category" id="category">
                <input class="taxInput" placeholder="Tax" type="number" name="tax" id="tax">
            </div>

            <input type="submit" name="add" id="add" value="Add Categry">
        </form>
        <div class="tableCategory" style="border-left:1px solid rgba(0, 0, 0, 0.5) ;">
            <div class="containerTable" style="margin-left: 20px;">
                <table>
                    <tr>
                        <th class="thCode">Code</th>
                        <th id="line1" class="thCategory">Category</th>
                        <th id="line1" class="thTax">Tax</th>
                        <th id="line1" class="thActions">Actions</th>
                    </tr>
                    <tbody id="table">
                        <?php foreach ($categories as $category): ?>
                            <tr class="product1">
                                <td class="tdCode"><?= $category['code'] ?></td>
                                <td class="tdCategory"><?= $category['name'] ?></td>
                                <td class="tdTax"><?= $category['tax'] ?></td>
                                <td class="tdButton1">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="code" value="<?= $category['code'] ?>">
                                        <input type="submit" name="delete" class="delete1" value="Delete">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="scripts/category.js"></script>
</body>

</html>