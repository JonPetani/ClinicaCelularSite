<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<title>Our Inventory : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id='register'>Register Account</a>
<a href="login.php" id='login'>Log In</a>
<?php
setAccountTabs();
?>
</nav>
<br clear=both>
<main>
<br>
<h1>View Our Inventory</h1>
<?php
?>
</main>
</body>
</html>