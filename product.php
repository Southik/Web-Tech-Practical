<?php
session_start();

/* =============================
   LOAD CATEGORY + PRODUCT
   ============================= */

$category = $_GET['category'] ?? 'clothing';

if ($category === 'clothing') {
    $jsonPath = __DIR__ . '/ClothingItems.json';
} elseif ($category === 'shoes') {
    $jsonPath = __DIR__ . '/ShoesItems.json';
} else {
    die('Unknown category');
}

$json  = file_get_contents($jsonPath);
$items = json_decode($json, true);

$error   = null;
$product = null;

if (!isset($_GET['pid']) || trim($_GET['pid']) === '') {
    $error = "Product parameter is missing.";
} else {
    $pid = trim($_GET['pid']);
    foreach ($items as $item) {
        if ($item['pid'] === $pid) {
            $product = $item;
            break;
        }
    }
    if ($product === null) {
        $error = "Product not found.";
    }
}

/* =============================
   CART INITIALIZATION
   ============================= */

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$addedMessage = "";

/* =============================
   ADD PRODUCT TO CART
   ============================= */

if (isset($_POST['add']) && $product !== null) {

    $cartKey = $product['pid']; // ✅ UNIQUE PER PRODUCT

    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity']++;
    } else {
        $_SESSION['cart'][$cartKey] = [
            'pid'      => $product['pid'],
            'name'     => $product['name'],
            'price'    => $product['price'],
            'quantity' => 1
        ];
    }

    $addedMessage = "Product successfully added to cart!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        <?= $product ? htmlspecialchars($product['name']) : 'Product not found' ?>
    </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar">
    <div class="nav-left">
        <a href="Shoes/menShoeList.php">Shoes</a>
        <a href="Clothing/menClothesList.php">Clothing</a>
    </div>
    <div class="nav-right">
        <a href="login.php" class="login-button">Customer Login</a>
    </div>
</nav>

<?php if ($error !== null): ?>

    <!-- ERROR -->
    <section class="product-detail">
        <h1 class="page-title">Error</h1>
        <p><?= htmlspecialchars($error) ?></p>
        <a href="Clothing/menClothesList.php">
            <button class="nav-button">Go Back</button>
        </a>
    </section>

<?php else: ?>

    <!-- PRODUCT -->
    <section class="product-detail">
        <div class="product-layout full-width-layout">

            <div class="product-image-container full-image">
                <?php
                $imagePath = $product['image'];
                if (str_starts_with($imagePath, '../')) {
                    $imagePath = substr($imagePath, 3);
                }
                ?>
                <img src="<?= htmlspecialchars($imagePath) ?>"
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     class="product-image">
            </div>

            <div class="product-info">

                <h1 class="page-title">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>

                <p class="product-subtitle">
                    <?= htmlspecialchars($product['description']) ?>
                </p>

                <div class="product-price">
                    €<?= number_format($product['price'], 2) ?>
                </div>

                <!-- ADD TO CART -->
                <div class="product-actions">
                    <form method="post">
                        <input type="hidden" name="add" value="1">
                        <button type="submit" class="nav-button">
                            Add to Shopping Cart
                        </button>
                    </form>

                    <?php if ($addedMessage): ?>
                        <p style="color: green; font-weight: bold;">
                            <?= $addedMessage ?>
                        </p>
                    <?php endif; ?>
                </div>

                <p class="pickup-note">Free pickup available in store.</p>

            </div>
        </div>
    </section>

    <div class="navigation-buttons">
        <a href="<?= $category === 'clothing' ? 'Clothing/menClothesList.php' : 'Shoes/menShoeList.php' ?>">
            <button class="nav-button">Go Back</button>
        </a>
        <a href="shoppingCart.php">
            <button class="nav-button">Shopping Cart</button>
        </a>
    </div>

<?php endif; ?>

</body>
</html>
