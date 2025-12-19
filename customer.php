<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'] ?? [];
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
		<a href="logout.php"> 
            <button type="button" class="logout-button">Logout</button>
        </a>
    </div>
</nav>

<div class="customer-info">
	<h1> CUSTOMER PROFILE </h1>

	<table>
		<tr><th>Firstname:</th><td><?= htmlspecialchars($user['Firstname'] ?? '') ?></td></tr>
		<tr><th>Lastname:</th><td><?= htmlspecialchars($user['Lastname'] ?? '') ?></td></tr>
	</table>
	
	<a href="myOrders.php" class="customer-buttons">
		<button type="button">Manage Orders</button>
	</a>
	
</div>

</body>
</html>
