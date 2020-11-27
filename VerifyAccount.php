<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Account Verification Step 2 : Clínica Celular</title>
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
</nav>
<main align=center>
<br clear=both>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
if(isset($_SESSION['logged'])) {
	if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
		header("Location: loggedin.php");
		die;
	}
}
if(isset($_GET['account']) and isset($_GET['type'])) {
	switch($_GET['type']) {
		case 'verify':
		$sql = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :email");
		$address = urldecode($_GET['account']);
		$sql -> bindParam(':email', $address);
		$sql -> execute();
		if($sql -> rowCount() <= 0) {
			header("Location: loggedin.php");
			die;
		}
		$account = $sql -> fetch(PDO::FETCH_ASSOC);
		if($account['VerifiedAccount'] != 0) {
			header("Location: loggedin.php");
			die;
		}
		echo'<h1>One More Step Before You Can Use The Account</h1>';
		echo'<form action="login.php?action=verify&account=' . urldecode($_GET["account"]) . '&info=ecode" method="POST">';
		printError("loading", "Submission of Information Failed. Try Again.");
		echo'<input name="Code" type="password" placeholder="Enter The Code You Got In The Email or Text" required autocomplete="false"/>';
		printError("code", "Code Entered Doesn't Match The Email/Text's. Please Check The Message Again or Copy And Paste If Possible.");
		echo'<input type="submit" align=center value="Submit To Verify"/>';
		echo'</form>';
		break;
		
		case 'recoveryemployee':
		$sql = $con -> prepare("SELECT * FROM employee WHERE EmailAddress = :email");
		$address = urldecode($_GET['account']);
		$sql -> bindParam(':email', $address);
		$sql -> execute();
		if($sql -> rowCount() <= 0) {
			header("Location: employeeverify.php");
			die;
		}
		$account = $sql -> fetch(PDO::FETCH_ASSOC);
		echo'<h1>One More Step Before The Employee Security Code Can Be Disclosed</h1>';
		echo'<form action="employeeverify.php?action=code&account=' . urldecode($_GET["account"]) . '" method="POST">';
		printError("loading", "Submission of Information Failed. Try Again.");
		echo'<input name="Code" type="password" placeholder="Enter The Code You Got In The Email or Text" required autocomplete="false"/>';
		printError("code", "Code Entered Doesn't Match The Email/Text's. Please Check The Message Again or Copy And Paste If Possible.");
		echo'<input type="submit" align=center value="Submit To Verify"/>';
		echo'</form>';
		break;
	}
}
else {
	header("Location: loggedin.php");
	die;
}
?>
</main>
<script>
formSetup();
</script>
</body>
</html>