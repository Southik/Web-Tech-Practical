<?php
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

if (!isset($_GET['pid'])) {
    $error = "Parameter is missing!";
} else {
    $pid = trim($_GET['pid']);
    if ($pid === '') {
        $error = "No value for the parameter!";
    } else {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
	<?php
        if ($product !== null) {
            echo htmlspecialchars($product['name']);
        } else {
            echo 'Product not found';
        }
    ?>
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
        <button id="mode-toggle">Toggle Light Mode</button>
        <script src="lightMode.js" defer></script>
    </nav>

<?php if ($error !== null): ?>

<section class="product-detail">
        <h1 class="page-title">Error</h1>
        <p><?php echo htmlspecialchars($error); ?></p>
        <div class="navigation-buttons">
            <a href="Clothing/menClothesList.php">
                <button type="button" class="nav-button">Go Back</button>
            </a>
        </div>
    </section>

<?php else: ?>

    <section class="product-detail">
        <div class="product-layout full-width-layout">
            <div class="product-image-container full-image">
                
				<?php
				$imagePath = $product['image'];
				if (str_starts_with($imagePath, '../')) {
					$imagePath = substr($imagePath, 3);
				}
				?>
				
				<img src="<?php echo htmlspecialchars($imagePath); ?>"
				alt="<?php echo htmlspecialchars($product['name']); ?>"
				class="product-image">
            
			</div>

            <div class="product-info">
                
				<h1 class="page-title">
					<?php echo htmlspecialchars($product['name']); ?>
				</h1>
                
				<p class="product-subtitle">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>
				
                <div class="product-price">
					€<?php echo number_format($product['price'], 2); ?>
				</div>

                <div class="size-selector">
                    <label>Select Size:</label>
                    <div class="size-options">
                        <label>
                            <input type="radio" name="size" value="S">
                            <span class="size-button">S</span>
                        </label>
                        <label>
                            <input type="radio" name="size" value="M">
                            <span class="size-button">M</span>
                        </label>
                        <label>
                            <input type="radio" name="size" value="L">
                            <span class="size-button">L</span>
                        </label>
                        <label>
                            <input type="radio" name="size" value="XL">
                            <span class="size-button">XL</span>
                        </label>
                        <label>
                            <input type="radio" name="size" value="XXL">
                            <span class="size-button">XXL</span>
                        </label>
                    </div>
                </div>

                <div class="product-actions">
                    <a href="../shoppingCartClothing.php">
                        <button type="button" class="nav-button">Add to Shopping Cart</button>
                    </a>
                </div>
                <p class="pickup-note">Free pickup available in store.</p>
            </div>
        </div>
    </section>
    <hr>

    <div class="navigation-buttons">
        <a href="../Clothing/menClothesList.php">
            <button type="button" class="nav-button">Go Back</button>
        </a>
        <a href="../shoppingCartClothing.php">
            <button type="button" class="nav-button">Shopping Cart</button>
        </a>
    </div>
	
<?php endif; ?>
</body>
</html>
