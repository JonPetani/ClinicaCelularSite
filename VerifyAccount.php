<!--
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Provides the Custom Form needed to Either Verify Account or Provide Recovery Login Information (Handles Multiple types of Email Related Account Actions)
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Account Verification Step 2 : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<div class="container">
<?php
setAccountTabs($con);
?>
<main align=center>
<br clear=both>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
//If Logged In, Go To Account Page
if(isset($_SESSION['logged'])) {
	if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
		header("Location: loggedin.php");
		die;
	}
}
//Page only Works When Correct Link From Sent Email is Used
if(isset($_GET['account']) and isset($_GET['type'])) {
	switch($_GET['type']) {
		//Verification Email For Customer Case
		case 'verify':
		//Check GET Params to see if Valid, otherwise send to loggedin.php
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
		//Prints the Verification Form
		//Simply Write in The Verification Code Found in the Sent Email
		echo'<h1>One More Step Before You Can Use The Account</h1>';
		echo'<form action="login.php?action=verify&account=' . urldecode($_GET["account"]) . '&info=ecode" method="POST">';
		printError("loading", "Submission of Information Failed. Try Again.");
		echo'<input name="Code" type="password" placeholder="Enter The Code You Got In The Email or Text" required autocomplete="false"/>';
		printError("code", "Code Entered Doesn't Match The Email/Text's. Please Check The Message Again or Copy And Paste If Possible.");
		echo'<input type="submit" align=center value="Submit To Verify"/>';
		echo'</form>';
		break;
		
		//Employee Account Recovery Case
		case 'recoveryemployee':
		$sql = $con -> prepare("SELECT * FROM employee WHERE EmailAddress = :email");
		$address = urldecode($_GET['account']);
		$sql -> bindParam(':email', $address);
		$sql -> execute();
		if($sql -> rowCount() <= 0) {
			header("Location: employeeverify.php");
			die;
		}
		//Prints the Site Code Access Form
		//Simply Write in The Verification Code Found in the Sent Email
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
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>