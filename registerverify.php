<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
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
<div class="container">
<?php
setAccountTabs($con);
?>
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
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>