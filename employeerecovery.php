<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
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
if(isset($block))
	errorPageDisplay($block);
?>
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