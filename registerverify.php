<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Account Verification Step 1 : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
if(isset($_SESSION['logged'])) {
	if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
		header("Location: loggedin.php");
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
<br clear=both>
<h1>Looks Like You Still Need Your Account Verified. Give Us Your Address and We Will Guide You Through The Process</h1>
<form action="sendemail.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
?>
<input name="Email" type="email" placeholder="Enter The Email Address Assosiated With The Account You Wish To Verify" required autocomplete="false"/>
<?php
printError("email", "The Address Specified Does Not Match Any Accounts In Our System. If You Did Not Create a Account Yet, <a href='register.php'>Go Here</a> or Try Entering Again")
?>
<input type="submit" align=center name="EmailButton" value="Send Verification Email Now"/>
</form>
</main>
<script>
formSetup();
</script>
</body>
</html>