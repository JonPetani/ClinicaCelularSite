<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
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
<h1>Log In</h1>
<form action="loggedin.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("bug", "Something Went Wrong in your Account and Had to be Logged Off. Log In Again.");
printError("logout", "Logged Out Successfully");
?>
<input name="Uname" type="text" placeholder="Enter Your Email Address or Phone Number (Mobile or Landline)" required autocomplete="false"/>
<input name="Password" type="password" placeholder="Enter Your Password" required autocomplete="false"/>
<label for="keepOn">Keep Me Signed In</label>
<input name="keepOn" type="checkbox" autocomplete="false" value="si"/>
<?php
printError("login", "Username And/Or Password Incorrect. Please Check Before Trying Again.")
?>
<input type="submit" align=center value="Create Now"/>
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