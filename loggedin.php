<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(empty($_POST['Uname']) or (preg_match('^.*@.*$^', $_POST['Uname']) == 0 and preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['Uname']) == 0)) {
		header("Location: login.php?error=loading");
		die;
	}
	$methods = openssl_get_cipher_methods();
	$currentMethod = $methods[random_int(0, sizeof($methods))];
	$sql = $con -> prepare("SELECT * FROM customer WHERE (EmailAddress = :Uname OR Phone = :Uname OR MobilePhone = :Uname) AND Password = :Password");
	$sql -> bindParam(":Uname", $_POST['Uname']);
	$sql -> bindParam(":Password", $_POST['Password']);
	$sql -> execute();
	if(!isset($sql) or is_null($sql)) {
		header("Location: login.php?error=login");
		die;
	}
	$_SESSION['key'] = randomCodeGenerator();
	$user = $sql -> fetch(PDO::FETCH_ASSOC);
	$length = openssl_cipher_iv_length($currentMethod);
	$iv = openssl_random_pseudo_bytes($length);
	$_SESSION['account'] = $user['CustomerId'];
	$_SESSION['fname'] = openssl_encrypt($user['FirstName'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['lname'] = openssl_encrypt($user['LastName'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['email'] = openssl_encrypt($user['EmailAddress'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['lphone'] = openssl_encrypt($user['Phone'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['mphone'] = openssl_encrypt($user['MobilePhone'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['zip'] = openssl_encrypt($user['ZipCode'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['address'] = openssl_encrypt($user['Address'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['stay'] = (bool)$user['KeepLoggedIn'];
	$_SESSION['password'] = openssl_encrypt($user['Password'], $currentMethod, $_SESSION['key'], 0, $iv);
	$_SESSION['logged'] = 'loggedin';
	$_SESSION['type'] = 'customer';
	$update = $con -> prepare("UPDATE customer SET KeepLoggedIn = :keep, SecureMethod = :cm, IVLength = :iv, CipherKey = :key WHERE Password = :pass");
	$update -> bindParam(':keep', $_SESSION['stay']);
	$update -> bindParam(':cm', $currentMethod);
	$update -> bindParam(':iv', $iv);
	$update -> bindParam(':key', $_SESSION['key']);
	$pass = openssl_decrypt($_SESSION['password'], $currentMethod, $_SESSION['key'], 0, $iv);
	$update -> bindParam(':pass', $pass);
	$update -> execute();
	
}
else {
	if(isset($_SESSION['logged'])) {
		if($_SESSION['logged'] != true) {
			header("Location: login.php");
			die;
		}
	}
	else {
		header("Location: login.php");
		die;
	}
}
?>
<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<body>
<main>
<h1> Welcome Back <?php echo decryptDisplay($_SESSION['fname'], $con);?></h1>
<p>Now that your signed in, you may begin your purchases as you desire.</p>
<a href="store.php" align=center id="sms">To Our Merchandise</a>
</main>
</body>
</html>