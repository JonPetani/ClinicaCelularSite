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
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
if(isset($_SESSION['logged'])) {
	if($_SESSION['logged'] == true) {
		switch($_SESSION['type']) {
			case "customer":
			$block = "Error: Restricted From Customers.";
			break;
			
			case "employee":
			header("Location: employeehome.php");
			die;
			
			default:
		    $block = "Error: Please Enter Employee Code On <a href='employeeverify.php'>This Page</a> Before Proceeding If Employee. Otherwise is Restricted.";
			break;
		}
	}
	else {
		header("Location: employeeverify.php?error=loading");
		die;
	}
}
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$sql = $con -> prepare("SELECT * FROM sitecodes WHERE CodeName = :ecode");
	$codename = "EmployeeCode";
	$sql -> bindParam(":ecode", $codename);
	$sql -> execute();
	$ecode = $sql -> fetch(PDO::FETCH_ASSOC);
	if(strcmp($_POST['Code'], $ecode['CodeValue']) != 0) {
		header("Location: employeeverify.php?error=mismatch");
		die;
	}
	$ecode_array = array('CodeValue' => $ecode['CodeValue']);
	encryptSet($ecode_array, $con);
}
else {
	if(isset($_SESSION['CodeValue'])) {
		isEmployee($con, decryptDisplay($_SESSION['CodeValue'], $con));
	}
	else {
		header("Location: employeeverify.php?error=nodata");
		die;
	}
}
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
<form action="employeehome.php" method="POST">
<?php
printError("password", "Wrong Password");
printError("earlylogout", "Password Wasn't Logged Properly. Re-Login To Get Back In");
?>
<h1>Employee Verification Successful. Simply enter your Employee information to get access to your Account</h1>
<input name="EPassword" type="password" placeholder="Your Employee Password" required autocomplete="false"/>
<a href='ForgotEmployee.php'>Forgot Password</a>
<input type="submit" value="Log On"/>
</form>
</main>
<script>
formSetup();
</script>
</body>
</html>