<html>
<body>
<?php
require "PHPAssets/connect.php";
if(strcmp($_POST['Terms'], "si") != 0) {
	header("Location: register.php?error=terms");
	die;
}
if(strlen($_POST['First']) < 2) {
	header("Location: register.php?error=first");
	die;
}
if(strlen($_POST['Last']) < 2) {
	header("Location: register.php?error=last");
	die;
}
if(!preg_match('^.*@.*$^', $_POST['Email'])) {
	header("Location: register.php?error=email");
	die;
}
if(!preg_match("^[0-9]{1,5},.{7,}$^", $_POST['Address'])) {
	header("Location: register.php?error=address");
	die;
}
if(!Empty($_POST['LPhone'])) {
	if(!preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['LPhone'])) {
		header("Location: register.php?error=lphone");
		die;
	}
}
if(!preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^', $_POST['MPhone'])) {
	header("Location: register.php?error=mphone");
	die;
}
if(!preg_match('^[0-9]{5}$^', $_POST['zipCode'])) {
	header("Location: register.php?error=zip");
	die;
}
$hasUpper = false;
$hasLower = false;
$hasNum = false;
foreach($char as $_POST['Password']) {
	if(preg_match('[A-Z]', $char))
		$hasUpper = true;
	if(preg_match('[a-z]', $char))
		$hasLower = true;
	if(preg_match('[0-9]', $char))
		$hasNum = true;
	if($hasUpper == true and $hasLower == true and $hasNum == true)
		break;
}
if($hasUpper == false or $hasLower == false or $hasNum == false or strlen($_POST['Password']) < 12) {
	header("Location: register.php?error=password");
	die;
}
if(strcmp($_POST['keepOn'], "si") !== 0)
	$keepLoggedIn = false;
else
	$keepLoggedIn = true;
if(strcmp($_POST['emailList'], "si") !== 0)
	$emailList = false;
else
	$emailList = true;
$sql = $con -> prepare("INSERT INTO customer (FirstName, LastName, Password, EmailAddress, Phone, MobilePhone, ZipCode, Address, KeepLoggedIn, EmailList, VerifiedAccount) VALUES (:First, :Last, :Password, :Email, :LPhone, :MPhone, :zipCode, :Address, :keepLoggedIn, :emailList, :verify)");
$sql -> bindParam(":First", $_POST['First']);
$sql -> bindParam(":Last", $_POST['Last']);
$sql -> bindParam(":Password", $_POST['Password']);
$sql -> bindParam(":Email", $_POST['Email']);
$sql -> bindParam(":LPhone", $_POST['LPhone']);
$sql -> bindParam(":MPhone", $_POST['MPhone']);
$sql -> bindParam(":zipCode", $_POST['zipCode']);
$sql -> bindParam(":Address", $_POST['Address']);
$sql -> bindParam(":keepLoggedIn", $keepLoggedIn);
$sql -> bindParam(":emailList", $emailList);
$sql -> bindParam("verify", false);
$sql -> execute();
?>
<h1>Registration Successful</h1>
<p>To verify your identity we will send you a text. Click the button below when your ready</p>
<a href="registerverify.php">Send SMS Text Verification Now</a>
</body>
</html>