<?php
session_start();
session_destroy();
header("Location: index.php");
exit;
?>
<!DOCTYPE html>
<html>
<head>
	<title> LoggedOut </title>
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
	<center><br><br><br><br><br><br>
		<h1 align=center> YOU ARE LOGGED OUT!! <h1>
		<a href=login.php><button class="customer-profile-and-logout-buttons">Go Back</button></a>
		<a href=index.php><button class="customer-profile-and-logout-buttons">HOME</button></a>
	</center>
</body>
</html>