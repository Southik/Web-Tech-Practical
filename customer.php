<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title> Customer Profile </title>
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

<div class="customer-info">
	<h1> CUSTOMER PROFILE </h1>

	<table>
		<tr><th>Firstname:</th><td>Michael</td></tr>
		<tr><th>Lastname:</th><td>Jackson</td></tr>
		<tr><th>Password:</th><td>Wslknoihoi324DCC</td></tr>
	</table><br>

	<p>This is the current User Data</p>

	<div class="customer-buttons">Change Info</div><br>

	<div>
		<a href="login.php" class="customer-buttons">Go Back</a>
		<a href="logout.php" class="customer-buttons">Logout</a>
		<a href="index.php" class="customer-buttons">Unregister</a>
	</div>
</div>

</body>
</html>
