<?php
session_start();

/* SET LOGIN SESSION */
if (
    isset($_GET['username'], $_GET['password']) &&
    $_GET['username'] !== '' &&
    $_GET['password'] !== ''
) {
    $_SESSION['user_id'] = $_GET['username'];
}

/* REDIRECT BACK AFTER LOGIN */
if (isset($_SESSION['redirect_after_login'])) {
    $redirect = $_SESSION['redirect_after_login'];
    unset($_SESSION['redirect_after_login']);
    header("Location: $redirect");
    exit;
}
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
	</table>
</div>

</body>
</html>
