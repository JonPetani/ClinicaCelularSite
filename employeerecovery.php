<!--
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: If Employee forgets Employee Code or is Changed They can request the New One Through The Account Recovery Process
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Employee Account Recovery</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
//Create Error Message If User is Logged To Warn About Going Here, Otherwise Bring to Default Login
if(isset($_SESSION['logged'])) {
	switch($_SESSION['type']) {
		case 'customer':
		$block = 'Page Error: Non-Employees are Restricted from This Page';
		break;
		
		case 'employee':
		$block = 'Page Error: Already Logged Into Employee Account';
		break;
		
		default:
		header("Location: login.php?error=accessdenied");
		die;
	}
}
?>
<div class="container">
<?php
setAccountTabs($con);
?>
<main align=center>
<br clear=both>
<?php
//Print Appropriate Restriction Message and Stop Page Loadout
if(isset($block))
	errorPageDisplay($block);
?>
<!--Employee Email Verify Form-->
<!--Employee Enters Their Company Email Address-->
<h1>Looks Like You Still Need Your Account Verified. Give Us Your Address and We Will Guide You Through The Process</h1>
<form action="sendemail.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
?>
<input name="Email" type="email" placeholder="Enter Your Company Email Address" required autocomplete="false"/>
<?php
printError("email", "The Address Specified Does Not Match Any Employee Accounts In Our System. Try Entering Again Please.")
?>
<input type="submit" align=center name="EmailButton" value="Send Employee Recovery Email Now"/>
</form>
</main>
<script>
formSetup();
</script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>