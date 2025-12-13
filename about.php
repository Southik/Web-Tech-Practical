<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>About Us</title>
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
	<div style="text-align: center;">
		<h1>About Us</h1>

		<h3>You found us!</h3>

		<p><strong>Welcome to "shop name"!</strong> We are an Independent clothing store which offers the <br>
		<b>highest quality and latest</b> in fashion, style, and trends.</p>

		<p>We believe everyone deserves to feel confident and express themselves through what they wear. <br>
		That’s why we bring you a carefully curated selection of clothing, shoes, and accessories — from timeless and elegant classics <br> 
		to the more modern and contemporary style.</p>

		<p>Our mission is simple: make elegance accessible, inspiring, and . <br>
		We work with trusted brands and underated labels to offer quality pieces that look good and feel even better.</p>

		<p>Whether you’re refreshing your wardrobe, dressing for a special occasion, or just exploring new trends, <br>
		<strong>"shope name"</strong> has something for every style and every season.</p>

		<h4>Stay stylish. Stay you.</h4>


			<section>

				<a href="index.php">
					<button type="button"><h3>Back to Homepage</h3></button>
				</a>
				<a href="login.php">
					<button type="button"><h3>Customer Login</h3></button>
				</a>
			</section>

	</div>
	<?php
		$text1 = "This is my first text in a variable.";
		echo $text1;
    ?>
</body>
</html>