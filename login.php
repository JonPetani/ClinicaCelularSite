<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Login To Account : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
require "PHPAssets/pagetools.php";
if(isset($_SESSION['logged'])) {
	if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
		header("Location: loggedin.php");
		die;
	}
}
if(isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'verify':
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sql = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :email");
			$sql -> bindParam(':email', $_GET['account']);
			$sql -> execute();
			$account = $sql -> fetch(PDO::FETCH_ASSOC);
			if(strcmp($account['VerifyCode'], $_POST['Code']) != 0) {
				$url = "VerifyAccount.php?account=" . urlencode($_GET['account']) . "&type=verify";
				header("Location: " . $url);
				die;
			}
			$verified = 1;
			$sql = $con -> prepare("UPDATE customer SET VerifiedAccount = :isverified WHERE EmailAddress = :email");
			$sql -> bindParam(':isverified', $verified);
			$sql -> bindParam(':email', $_GET['account']);
			$sql -> execute();
		}
		break;
	}
}
?>
<div class="container">
<?php
setAccountTabs($con);
?>
<main align=center>
<br clear=both>
<h1>Log In</h1>
<form action="loggedin.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("bug", "Something Went Wrong in your Account and Had to be Logged Off. Log In Again.");
printInfo("logout", "Logged Out Successfully");
printError("verifyneeded", "Account UnVerified. <a href='registerverify.php'>Go Here For Us To Send A Verification Email</a>");
printError("emailsent", "Verification Email Sent. Check Spam Folder If It Isn't In Your Inbox. If You Can't Find It Anywhere After 5 Minutes, <a href='registerverify.php'>Request Another Email Here</a>");
printError("nologin", "Data Attempt Requested With No Login");
printError("deployment", "Data was not collected correctly. Try again please.");
if(isset($verified)) {
	if($verified == true) {
		echo "<p>Account Successfully Verified. Now You Can Login.</p>";
	}
}
?>
<input name="Uname" type="text" placeholder="Enter Your Email Address or Phone Number (Mobile or Landline)" required autocomplete="false"/>
<input name="Password" type="password" placeholder="Enter Your Password" required autocomplete="false"/>
<label for="keepOn">Keep Me Signed In</label>
<input name="keepOn" type="checkbox" autocomplete="false" value="si"/>
<?php
printError("login", "Username And/Or Password Incorrect. Please Check Before Trying Again.")
?>
<input type="submit" align=center value="Log On"/>
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