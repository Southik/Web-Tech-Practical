<?php
session_start();

function loadJson($path) {
    if (!file_exists($path)) return [];
    $content = file_get_contents($path);
    if ($content === '' || $content === false) return [];
    $data = json_decode($content, true);
    return is_array($data) ? $data : [];
}

function saveJson($path, $data) {
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
}

$regError = '';
$regSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['Email'] ?? '';
    $password = $_POST['Password'] ?? '';
    $confirm  = $_POST['Confirmed-Password'] ?? '';

    if ($password !== $confirm) {
        $regError = "Passwords do not match.";
    } else {
        $customersPath = __DIR__ . '/customers.json';
        $customers     = loadJson($customersPath);

        foreach ($customers as $c) {
            if (($c['Email'] ?? '') === $email) {
                $regError = "A user with this email already exists.";
                break;
            }
        }

        if ($regError === '') {
            $newCustomer = [
                'Firstname'        => $_POST['Firstname']        ?? '',
                'Lastname'         => $_POST['Lastname']         ?? '',
                'Email'            => $email,
                'Telephone-Number' => $_POST['Telephone-Number'] ?? '',
                'Date-of-birth'    => $_POST['Date-of-birth']    ?? '',
                'Password'         => $password,
                'Address'          => $_POST['Address']          ?? '',
                'Gender'           => $_POST['Gender']           ?? '',
                'Privacy-policy'   => isset($_POST['Privacy-policy']),
                'blocked'          => false
            ];

            $customers[] = $newCustomer;
            saveJson($customersPath, $customers);

            $regSuccess = "Registration successful. You can now log in.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Customer Registration</title>
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
<br>
    <div class="registration-form-container">
        <h1 class="registration-heading">Customer Registration</h1>
		
		<?php if ($regError): ?>
			<p style="color:red;"><?php echo htmlspecialchars($regError); ?></p>
		<?php endif; ?>
		<?php if ($regSuccess): ?>
			<p style="color:green;"><?php echo htmlspecialchars($regSuccess); ?></p>
		<?php endif; ?>
		
        <form action="registration.php" method="post" autocomplete="on">
            <label for="firstname">Firstname:</label><br/>
            <input type="text" id="firstname" name="Firstname" placeholder="Firstname" required><br/><br/>

            <label for="lastname">Lastname:</label><br/>
            <input type="text" id="lastname" name="Lastname" placeholder="Lastname" required><br/><br/>

            <label for="email">Email address:</label><br/>
            <input type="email" id="email" name="Email" placeholder="xyz@mymail.com" required><br/><br/>

            <label for="tel">Telephone Number:</label><br/>
            <input type="tel" id="tel" name="Telephone-Number" placeholder="Start with your country code (e.g. +49XXX...)" 
                   size="35" required><br/><br/>

            <label for="dob">Date of Birth:</label><br/>
            <input type="date" id="dob" name="Date-of-birth" min="1950-01-01" max="2008-01-01" required><br/><br/>

            <label for="password">Choose a Password:</label><br/>
            <input type="password" id="password" name="Password" required><br/><br/>

            <label for="confirm-password">Retype your Password:</label><br/>
            <input type="password" id="confirm-password" name="Confirmed-Password" required><br/><br/>

            <label for="address">Address:</label><br/>
            <input type="text" id="address" name="Address" placeholder="Street and House number" required><br/><br/>

            <label>Gender:</label><br/>

            <div class="gender-options">
				<input type="radio" id="male" name="Gender" value="Male" required>
				<label for="male" class="gender-btn">Male</label>

				<input type="radio" id="female" name="Gender" value="Female">
				<label for="female" class="gender-btn">Female</label>

				<input type="radio" id="other" name="Gender" value="Other">
				<label for="other" class="gender-btn">Other</label>
			</div>

            <input type="checkbox" id="privacy" name="Privacy-policy" required>
            <label for="privacy">
                I have read and agree to the 
                <a href="/Privacy-policy" target="_blank" rel="Privacy-policy">Privacy Policy</a>. 
                I consent to the processing of my personal data for the purpose of managing my account and processing my orders.
            </label><br/><br/>

            <input type="submit" value="Register Now">
            <input type="reset" value="Reset"><br/><br/>

            <a href="login.php" id="back-button">
                <button type="button">Go Back</button>
            </a>
        </form>
    </div>
	<script src="validation.js" defer></script>
</body>
</html>
