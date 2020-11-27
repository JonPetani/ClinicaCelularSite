<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Sign Up : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Employee Verification</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/formtools.php";
require "PHPAssets/dir.php";
if(isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'verify':
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sql = $con -> prepare("SELECT * FROM employee WHERE EmailAddress = :email");
			$sql -> bindParam(':email', $_GET['account']);
			$sql -> execute();
			$account = $sql -> fetch(PDO::FETCH_ASSOC);
			if(strcmp($account['VerifyCode'], $_POST['Code']) != 0) {
				$url = "VerifyAccount.php?account=" . urlencode($_GET['account']) . "&type=recoveryemployee";
				header("Location: " . $url);
				die;
			}
		}
		break;
	}
}
$verify_code = getEmployeeCodeAccess($con);
unset($verify_code);
adminPopulate($con);
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id="register">Register Account</a>
<a href="login.php" id="login">Log In</a>
</nav>
<main align=center>
<h2>This Page and Points Beyond Are Restricted to Employees</h2>
<p>Is protected by a security code. If you forgot it and didn't take note of it, press the button below to have it sent to your company email. Also check your inbox for possible changes in the code.</p>
<a href="employeerecovery.php" id="sms">Send Code</a>
<form action="employeelogin.php" method="POST">
<?php
printInfo("emailsent", "Recovery Email Sent");
printError("nodata", "No Employee Code Provided Before Entry Was Authorized. Please Enter It Below.-");
printError("mismatch", "Code Doesn't Match The Site's Employee Code. Try Again or Request it through the Account Recovery Tool Above.");
printError("employeeverifyfailed", "Only Employee's can view this content. If this is a error, relogin below.");
printInfo("logout", "Logged Out Successfully");
if(isset($verified)) {
	if($verified == true) {
		$code = getEmployeeCodeAccess($con);
		printInfo("ecode", "The Code of Employee Entry is " . $code . ".Make sure not to forget it this time.");
	}
}
?>
<input type="text" name="Code" placeholder="Enter The Employee Code" required autocomplete="false">
<input type="submit" value="Submit Code"/>
</form>
</main>
<script>
formSetup();
</script>
</body>
</head>