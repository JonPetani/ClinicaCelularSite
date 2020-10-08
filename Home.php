<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<title>Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
<body>
<?php
require "PHPAssets/connect.php"
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id="register">Register Account</a>
<a href="login.php" id="login">Log In</a>
<?php
if(isset($_SESSION['logged'])) {
	if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
		echo"<script>";
		echo"$('#register').remove();";
		echo"$('#login').remove();";
		echo"$('nav').append('<a href=\'logout.php\'>Log Out</a>');";
		echo"</script>";
	}
}
?>
</nav>
<br clear=both>
<main>
<br>
<h1>Clínica Celular</h1>
<p>Welcome to our site.</p>
</main>
<script>
$("h1").css("font-size", "275%");
</script>
</body>
</html>