<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Men's Jackets List</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
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
            <div class="product-card">
                <img src="../img/menJacket1.png" alt="Stylish Black Leather Jacket" class="product-image">
                <div class="product-name">Stylish Black Leather Jacket</div>
                <div class="product-description">
                    Premium handcrafted leather, a classic design reimagined for everyday wear and special occasions.
                </div>
                <div class="product-price">€120.00</div>
                <a href="menJacket1.php" class="details-button">View Details</a>
				
				<form>
					<input type="number" min="1" value="1" class="quantity-input"/>
					<button type="button" class="collection-button" onclick="addToCollectionListC(this)">Add to Collection List</button>
				</form>
            </div>

            <div class="product-card">
                <img src="../img/menJacket2.png" alt="Casual Blue Denim Jacket" class="product-image">
                <div class="product-name">Casual Blue Denim Jacket</div>
                <div class="product-description">
                    Highest quality Denim Jacket - Perfect blend of comfort, style, and practicality.
                </div>
                <div class="product-price">€109.99</div>
                <a href="menJacket2.php" class="details-button">View Details</a>
				
				<form>
					<input type="number" min="1" value="1" class="quantity-input"/>
					<button type="button" class="collection-button" onclick="addToCollectionListC(this)">Add to Collection List</button>
				</form>
            </div>
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

<script src="../collection.js"></script>
</body>
</html>
