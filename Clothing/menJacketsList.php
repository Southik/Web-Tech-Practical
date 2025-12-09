<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Men's Jackets List</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
<?php
$json = file_get_contents(__DIR__ . '/../ClothingItems.json');
$items = json_decode($json, true);
?>

    <nav class="navbar">
        <div class="nav-left">
            <a href="../Shoes/menShoeList.php">Shoes</a>
            <a href="../Clothing/menClothesList.php">Clothing</a>
        </div>
        <div class="nav-right">
            <a href="../login.php" class="login-button">Customer Login</a>
        </div>
        <button id="mode-toggle">Toggle Light Mode</button>
        <script src="../lightMode.js" defer></script>
    </nav>

    <h1 class="page-title">ALL THE JACKETS FOR MEN</h1>
    <div class="category" id="jackets">
        <h3 class="category-title">Jackets</h3>
        <hr>
        <p class="subtitle-shoe"><i>Stylish and versatile jackets made for every season.</i></p>
        <br>
        <div class="product-grid">
		
		<?php foreach ($items as $item): ?>
        <?php if ($item['category'] !== 'Jackets') continue; ?>
		
            <div class="product-card">
                
				<img src="<?php echo htmlspecialchars($item['image']); ?>"
                 alt="<?php echo htmlspecialchars($item['name']); ?>"
                 class="product-image">
				 
                <div class="product-name">
					<?php echo htmlspecialchars($item['name']); ?>
				</div>
				
                <div class="product-description">
                    <?php echo htmlspecialchars($item['description']); ?>
                </div>
				
                <div class="product-price">
					€<?php echo number_format($item['price'], 2); ?>
				</div>
				
                <a href="../product.php?category=clothing&pid=<?php echo urlencode($item['pid']); ?>" class="details-button">View Details</a>
				
				<form>
					<input type="number" min="1" value="1" class="quantity-input"/>
					<button type="button" class="collection-button" onclick="addToCollectionListC(this)">Add to Collection List</button>
				</form>
            </div>
        <?php endforeach; ?>     
        </div>
    </div>
	
	<div class="collection-list-container">
		<h2 style="text-align: center">Collection List</h2>
		<ul id="collection-list"></ul>
	</div>


    <div class="navigation-buttons">
        <a href="../Clothing/menClothesList.php">
            <button type="button" class="nav-button">Go Back</button>
        </a>
        <a href="../shoppingCartClothing.php">
            <button type="button" class="nav-button">Shopping Cart</button>
        </a>
    </div>
	
	<!-- Calculator  -->
	<div class="tax-calculator">
    <h2>Price Calculator (with 19% Tax)</h2>

    <label>Price Without Tax (€):</label>
    <input type="number" id="priceWOTax" min="0" step="0.01">

    <button type="button" onclick="showTotalPrice()">Calculate</button>

    <p id="price-result"></p>
	</div> <br><br>
	<!-- EXTRA 2 FUNCTIONS -->
	<button type="button" onclick="togglePrices()">Show/Hide All Prices</button>
	<button type="button" onclick="highlightExpensive()">Highlight Expensive Items</button>
	<br><br>
	
<script src="../priceCalculator.js"></script>
<script src="../collection.js"></script>
</body>
</html>
