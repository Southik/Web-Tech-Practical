<?php
session_start();

function loadJson($path) {
    if (!file_exists($path)) return [];
    $content = file_get_contents($path);
    if ($content === '' || $content === false) return [];
    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $customers = loadJson(__DIR__ . '/customers.json');

    $found = null;
    foreach ($customers as $c) {
        if (($c['Email'] ?? '') === $email && ($c['Password'] ?? '') === $password) {
            $found = $c;
            break;
        }
    }

    if ($found) {
    $_SESSION['user_id'] = $found['Email'];
    $_SESSION['user']    = $found;

    if ($found['Email'] === 'admin1@example.com') {
        $_SESSION['role'] = 'admin';
        header('Location: adminOrders.php');
        exit;
    } else {
        $_SESSION['role'] = 'customer';
        $redirect = $_SESSION['redirect_after_login'] ?? 'customer.php';
        unset($_SESSION['redirect_after_login']);
        header("Location: $redirect");
        exit;
    }
}

}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Customer Login</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <nav class="navbar">
        <a href="logout.php"> 
            <button type="button" class="logout-button">Logout</button>
        </a>
    <button id="mode-toggle">Toggle Light Mode</button>
    <script src="lightMode.js" defer></script>
    </nav>
        <div class="login-form-container">
            <h1>Customer Login</h1>
			<?php if ($loginError): ?>
				<p style="color:red;"><?php echo htmlspecialchars($loginError); ?></p>
			<?php endif; ?>
			
            <form action="login.php" method="post">
                <label for="username">Username:</label><br/>
                <input type="text" id="username" name="username" placeholder="abc@gmail.com" required><br/><br/>

                <label for="password">Password:</label><br/>
                <input type="password" id="password" name="password" placeholder="abc123" required><br/><br/>

                <input type="submit" value="Login">


                <a href="registration.php">
                    <button type="button">Registration</button>
                </a>
            </form>

            <br/><br/>

            <a href="index.php" id="back-button">
                <button type="button">Go Back</button>
            </a>
        </div>
		<script src="loginValidation.js" defer></script>

</body>
</html>
