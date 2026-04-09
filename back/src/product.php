<?php
session_start();
require_once 'conn.php';
require_once 'classes/ProductClass.php';
require_once 'controllers/ProductController.php';
require_once 'classes/CategoryClass.php';
require_once 'controllers/CategoryController.php';
$productController = new ProductController($myPDO);
$categoryController = new CategoryController($myPDO);
$categories = $categoryController->indexCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add'])) {
    $productController->createProduct($_POST['product'], $_POST['amount'] ?? '', $_POST['price'] ?? '', $_POST['category'] ?? '');
  } elseif (isset($_POST['delete'])) {
    $productController->deleteProduct($_POST['code']);
  }
}
$products = $productController->indexProducts();

?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles/product.css" />
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
    <form action="" method="post" class="fProduct">
      <div class="inputCima">
        <input maxlength="30" placeholder="Product name" type="text" name="product" id="product" />
      </div>
      <div class="inputBaixo">
        <input placeholder="Amount" type="number" name="amount" id="amount" class="amountInput" />
        <input placeholder="Price" step="0.01" type="number" name="price" id="price" class="priceInput" />
        <select name="category" id="select" class="categoryInput">
          <?php
          if ((!isset($categories)) || count($categories) <= 0) {
            echo "<option value='' selected disabled>Não existem categorias</option>";
          } else {
            echo "<option value='' disabled selected>Selecione uma categoria</option>";
          }
          foreach ($categories as $category) {
            echo "<option value='{$category['code']}'>{$category['name']}</option>";
          }
          ?>
        </select>
      </div>
      <button type="submit" name="add" id="addBtn">Add Product</button>
    </form>
    <div class="tableProduct" style="border-left: 1px solid rgba(0, 0, 0, 0.5)">
      <div class="containerTable" style="margin-left: 20px">
        <table>
          <tr>
            <th class="thCode">Code</th>
            <th id="line1" class="thProduct">Product</th>
            <th id="line1" class="thAmount">Amount</th>
            <th id="line1" class="thPrice">Price</th>
            <th id="line2" class="thCategory">Category</th>
            <th class="thActions">Actions</th>
          </tr>
          <tbody id="table">
            <?php foreach ($products as $product): ?>
              <tr class="product1">
                <td class="tdCode"><?= $product['display_code'] ?></td>
                <td class="tdProduct"><?= $product['name'] ?></td>
                <td class="tdAmount"><?= $product['amount'] ?></td>
                <td class="tdPrice">R$<?= number_format($product['price'], 2, ',', '.') ?></td>
                <td class="tdCategory">
                  <?php
                  foreach ($categories as $category) {
                    if ($category['code'] == $product['category_code']) {
                      echo $category['name'];
                    }
                  }
                  ?>
                </td>
                <td class="tdActions">
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="code" value="<?= $product['code'] ?>">
                    <input type="submit" name="delete" class="delete1" value="Delete" onclick="return confirm('Tem certeza que deseja excluir esse produto?')">
                  </form>
                </td>
              </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php require_once 'alert.php'; ?>
</body>

</html>
<script>
  const productName = document.getElementById("product");
  const newPrice = document.getElementById("price");
  const newAmount = document.getElementById("amount");
  const select = document.getElementById("select");

  const productObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.type === "attributes" || mutation.attributeName === "type") {
        if (productName.type !== "text") {
          productName.type = "text";
        }
      }
    });
  });
  productObserver.observe(productName, {
    attributes: true,
    attributeFilter: ["type"],
  });

  const priceObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.type === "attributes" || mutation.attributeName === "type") {
        if (newPrice.type !== "number") {
          console.log("Input type changed to text");
          newPrice.type = "number";
        }
      }
    });
  });
  priceObserver.observe(newPrice, {
    attributes: true,
    attributeFilter: ["type"],
  });

  const amountObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.type === "attributes" && mutation.attributeName === "type") {
        if (newAmount.type !== "number") {
          console.log("Input type changed to text");
          newAmount.type = "number";
        }
      }
    });
  });
  amountObserver.observe(newAmount, {
    attributes: true,
    attributeFilter: ["type"],
  });

  const selectObserver = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (
        mutation.type === "childList" ||
        mutation.type === "attributes" ||
        mutation.type === "subtree" ||
        mutation.type === "characterData"
      ) {
        console.log("Select options changed");
        window.location.reload();
        getCategories();
      }
    });
  });
  selectObserver.observe(select, {
    childList: true,
    attributes: true,
    subtree: true,
    characterData: true,
  });
</script>