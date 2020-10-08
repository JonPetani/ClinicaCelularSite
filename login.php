<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
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
				$url = "VerifyAccount.php?account=" . urlencode($_GET['account']);
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
<h1>Log In</h1>
<form action="loggedin.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("bug", "Something Went Wrong in your Account and Had to be Logged Off. Log In Again.");
printError("logout", "Logged Out Successfully");
printError("verifyneeded", "Account UnVerified. <a href='registerverify.php'>Go Here For Us To Send A Verification Email</a>");
printError("emailsent", "Verification Email Sent. Check Spam Folder If It Isn't In Your Inbox. If You Can't Find It Anywhere After 5 Minutes, <a href='registerverify.php'>Request Another Email Here</a>");
printError("accessdenied", "Logged Out Successfully");
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
$("input").after("<br><br>");
$("input").css("padding", "15px");
$("input[type=submit]").css("font-size", "150%");
$("input[type=text],input[type=email],input[type=tel],input[type=password]").click(function() {
	$(this).css({"height": "6.5%", "width": "67%"});
});
$("input[type=text],input[type=email],input[type=tel],input[type=password]").mouseleave(function() {
	$(this).css({"height": "5%", "width": "65%"});
});
$("input").siblings("p").css({"font-size": "85%", "color": "#fc3019", "font-family": "'Barlow Semi Condensed', sans-serif"});
</script>
</body>
</html>