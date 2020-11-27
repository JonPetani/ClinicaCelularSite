<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(empty($_POST['Uname']) or (preg_match('^.*@.*$^', $_POST['Uname']) == 0 and preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['Uname']) == 0)) {
		header("Location: login.php?error=loading");
		die;
	}
	$sql = $con -> prepare("SELECT * FROM customer WHERE (EmailAddress = :Uname OR Phone = :Uname OR MobilePhone = :Uname) AND Password = :Password");
	$sql -> bindParam(":Uname", $_POST['Uname']);
	$sql -> bindParam(":Password", $_POST['Password']);
	$sql -> execute();
	if(!isset($sql) or is_null($sql)) {
		header("Location: login.php?error=login");
		die;
	}
	$user = $sql -> fetch(PDO::FETCH_ASSOC);
	if((strcmp($user['EmailAddress'], $_POST['Uname']) != 0 and strcmp($user['MobilePhone'], $_POST['Uname']) != 0 and strcmp($user['Phone'], $_POST['Uname']) != 0) or strcmp($user['Password'], $_POST['Password']) != 0) {
		header("Location: login.php?error=login");
		die;
	}
	if(intval($user['VerifiedAccount']) == 0) {
		header("Location: login.php?error=verifyneeded");
		die;
	}
	$_SESSION['type'] = 'customer';
	$_SESSION['logged'] = 'loggedin';
	$status = encryptSet($user, $con);
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
<title>Account Overview : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id="register">Register Account</a>
<a href="login.php" id="login">Log In</a>
<?php
setAccountTabs();
?>
</nav>
<main>
<br clear=both>
<h1> Welcome Back <?php echo decryptDisplay($_SESSION['FirstName'], $con);?></h1>
<h1> Welcome Back <?php echo $_SESSION['FirstName'];?></h1>
<p>Now that your signed in, you may begin your purchases as you desire.</p>
<a href="store.php" style="text-align:center;" id="sms">To Our Merchandise</a>
</main>
</body>
</html>