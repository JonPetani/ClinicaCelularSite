<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
require "PHPAssets/formtools.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	isEmployee($con, decryptDisplay($_SESSION['CodeValue'], $con));
	$sql = $con -> prepare("SELECT * FROM employee WHERE Password = :pass");
	$sql -> bindParam(':pass', $_POST['EPassword']);
	$sql -> execute();
	if($sql -> rowCount() < 1) {
		header("Location: employeelogin.php?error=password");
		die;
	}
	$employee = $sql -> fetch(PDO::FETCH_ASSOC);
	$_SESSION['logged'] = 'loggedin';
	$_SESSION['type'] = 'employee';
	$encrypt = encryptSet($employee, $con);
}
else {
	if(isset($_SESSION['Password'])) {
		isEmployee($con, decryptDisplay($_SESSION['CodeValue'], $con));
		$sql = $con -> prepare("SELECT * FROM employee WHERE Password = :pass");
		$P = decryptDisplay($_SESSION['Password'], $con);
		$sql -> bindParam(':pass', $P);
		unset($P);
		$sql -> execute();
		if($sql -> rowCount() < 1) {
			header("Location: employeelogin.php?error=earlylogout");
			die;
		}
	}
	else {
		header("Location: employeelogin.php?error=earlylogout");
		die;
	}
}
?>
<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="JS/formsetup.js"></script>
<title>Worker Hub : Clínica Celular</title>
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
<h1> All Set <?php echo decryptDisplay($_SESSION['FirstName'], $con);?></h1>
<p>Now that your signed in, get to work.</p>
<?php
if(isset($employee['AdminPassword'])) {
	if(!empty($employee['AdminPassword'])) {
		if(!isset($_SESSION['admin'])) {
			unset($employee['AdminPassword']);
			unset($_SESSION['AdminPassword']);
			echo "<h1>This Account is Listed as an System Admin one. To get Admin Access, Enter your Administrator's Password Below</h1>";
			echo "<form action='adminlogin.php' method='POST'>";
			printError('password', 'The Admin Password Entered Was Incorrect');
			echo "<input type='password' name='ACode' placeholder='Your Administrator's Password' autocomplete='false' required/>";
			echo "<input type='submit' value='Get Admin Access Now'/>";
			echo "</form>";
		}
	}
}
?>
</main>
<script>
formSetup();
</script>
</body>
</html>