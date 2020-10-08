<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Sign Up : Clínica Celular</title>
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
<h1>Create Account</h1>
<form action="signedup.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("duplicate", "Account With Existing Email, Mobile Phone, and/or Landline Phone Exists Already. If This Shouldn't Be The Case, Contact Support Here.");
?>
<input name="First" type="text" placeholder="First Name" required autocomplete="false"/>
<?php 
printError("first", "First Name Should Be More Than One Charecter");
?>
<input name="Last" type="text" placeholder="Last Name" required autocomplete="false"/>
<?php 
printError("last", "Last Name Should Be More Than One Charecter");
?>
<input name="Address" type="text" placeholder="Address" required autocomplete="true" pattern="^[0-9]{1,5},.{7,}$"/>
<?php 
printError("address", "Address Format Is Incorrect (Correct Example: 450, taco road)");
?>
<input name="zipCode" type="text" placeholder="Zip Code" required autocomplete="true" pattern="^[0-9]{5}$"/>
<?php 
printError("zip", "Zipcode needs 5 digits");
?>
<input name="MPhone" type="tel" placeholder="Mobile Phone Number (Required)" required autocomplete="false" pattern="^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$"/>
<?php 
printError("mphone", "Number Format Incorrect (Correct Examples: 43-4553-3454 or 345-452-2943)");
?>
<input name="LPhone" type="tel" placeholder="Non Mobile Phone Number (Optional)" required autocomplete="false" pattern="^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$"/>
<?php 
printError("lphone", "Number Format Incorrect (Correct Examples: 43-4553-3454 or 345-452-2943)");
?>
<input name="Email" type="email" placeholder="Email Address" required autocomplete="false"/>
<?php 
printError("email", "Not A Valid Email Address");
?>
<input name="Password" type="password" placeholder="Password (Must Include One Uppercase, One Lower Case, One Number, and be at Least 12 Charecters Long)" required autocomplete="false"/>
<?php 
printError("password", "Password Doesn't Meet Requirements. (Must Have One Uppercase Letter, One Lower Letter, One Number, And Be 12 Charecters Minimum)");
?>
<label for="keepOn">Keep Me Signed In</label>
<input name="keepOn" type="checkbox" autocomplete="false" value="si"/>
<label for="emailList">Add to Email List for Special Offers and Coupons</label>
<input name="emailList" type="checkbox" autocomplete="false" value="si"/>
<label for="Terms">Must Agree With Terms Of Service</label>
<input name="Terms" type="checkbox" autocomplete="false" required value="si"/>
<?php 
printError("terms", "Must Accept Terms of Service");
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