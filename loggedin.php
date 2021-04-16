<!--
Developer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Customer Main Page Upon Logging In. Sends To Login Form If Credentials Input Are Wrong Or Link Is Reached Without Form Submission Of Login Form
-->
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	//check for bad post inputs
	if(empty($_POST['Uname']) or (preg_match('^.*@.*$^', $_POST['Uname']) == 0 and preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['Uname']) == 0)) {
		header("Location: login.php?error=loading");
		die;
	}
	//get customer records
	$sql = $con -> prepare("SELECT * FROM customer WHERE (EmailAddress = :Uname OR Phone = :Uname OR MobilePhone = :Uname) AND Password = :Password");
	$sql -> bindParam(":Uname", $_POST['Uname']);
	$sql -> bindParam(":Password", $_POST['Password']);
	$sql -> execute();
	if(!isset($sql) or is_null($sql)) {
		header("Location: login.php?error=login");
		die;
	}
	$user = $sql -> fetch(PDO::FETCH_ASSOC);
	//check if login form input matches a entry in db
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
	//encrypt login data
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<title>Account Overview : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<div class="container">
<?php
setAccountTabs($con);
?>
<br clear=both>
<main>
<br clear=both>
<!---->
<h1> Welcome Back <?php echo decryptDisplay($_SESSION['FirstName'], $con);?></h1>
<p>Now that your signed in, you may begin your purchases as you desire.</p>
<a href="store.php" style="text-align:center;" id="sms">To Our Merchandise</a>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</main>
</body>
</html>