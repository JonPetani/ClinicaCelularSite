<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="JS/formsetup.js"></script>
<script src="JS/pagesetup.js"></script>
<title>Sign Up : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/formtools.php";
?>
<div class="container" style='background-color:CornFlowerBlue;'>
<div class="container" style='background-color:DarkSlateBlue;'>
<?php
setAccountTabs($con);
?>
</div>
<div class='container bg-primary text-white'>
<br>
<h1>Create Account</h1>
<?php
if(isset($_GET['addon'])) {
	if(strcmp($_GET['addon'], 'hub') == 0) {
		echo "<div class='container bg-info text-white justify-content-center'>";
		echo "<h2>Have a Account Already?</h2>";
		echo "<a href='login.php'></a>";
		echo "</div>";
	}
}
?>
<form action="signedup.php" method="POST">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("duplicate", "Account With Existing Email, Mobile Phone, and/or Landline Phone Exists Already. If This Shouldn't Be The Case, Contact Support Here.");
printError("bug", "A bug occured duribg a site operation. Please Sign Up with Account if not done so already to fix or Login.");
?>
<div class='form-group'><input class="form-control" name="First" type="text" placeholder="First Name" required autocomplete="false"/></div>
<?php 
printError("first", "First Name Should Be More Than One Charecter");
?>
<input class="form-control" name="Last" type="text" placeholder="Last Name" required autocomplete="false"/>
<?php 
printError("last", "Last Name Should Be More Than One Charecter");
?>
<input class="form-control" name="Address" type="text" placeholder="Address" required autocomplete="true" pattern="^[0-9]{1,5},.{7,}$"/>
<?php 
printError("address", "Address Format Is Incorrect (Correct Example: 450, taco road)");
?>
<input class="form-control" name="zipCode" type="text" placeholder="Zip Code" required autocomplete="true" pattern="^[0-9]{5}$"/>
<?php 
printError("zip", "Zipcode needs 5 digits");
?>
<input class="form-control" name="MPhone" type="tel" placeholder="Mobile Phone Number (Required)" required autocomplete="false" pattern="^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$"/>
<?php 
printError("mphone", "Number Format Incorrect (Correct Examples: 43-4553-3454 or 345-452-2943)");
?>
<input class="form-control" name="LPhone" type="tel" placeholder="Non Mobile Phone Number (Optional)" required autocomplete="false" pattern="^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$"/>
<?php 
printError("lphone", "Number Format Incorrect (Correct Examples: 43-4553-3454 or 345-452-2943)");
?>
<input class="form-control" name="Email" type="email" placeholder="Email Address" required autocomplete="false"/>
<?php 
printError("email", "Not A Valid Email Address");
?>
<input class="form-control" name="Password" type="password" placeholder="Password (Must Include One Uppercase, One Lower Case, One Number, and be at Least 12 Charecters Long)" required autocomplete="false"/>
<?php 
printError("password", "Password Doesn't Meet Requirements. (Must Have One Uppercase Letter, One Lower Letter, One Number, And Be 12 Charecters Minimum)");
?>
<div class="custom-control custom-checkbox">
<label class='custom-control-label' for="keepOn">Keep Me Signed In</label>
<input class='custom-control-input' name="keepOn" type="checkbox" autocomplete="false" value="si"/>
</div>
<label for="emailList">Add to Email List for Special Offers and Coupons</label>
<input name="emailList" type="checkbox" autocomplete="false" value="si"/>
<label for="Terms">Must Agree With Terms Of Service</label>
<input name="Terms" type="checkbox" autocomplete="false" required value="si"/>
<?php 
printError("terms", "Must Accept Terms of Service");
?>
<input type="submit" align=center value="Create Now"/>
</form>
<br>
</div>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</div>
<div class="container" style='background-color:DarkSlateBlue;'>
<ul class="nav justify-content-center">
<li class='nav-item dropdown'>
<a class='nav-link dropdown-toggle' data-toggle='dropdown' href=''>Our Services</a>
<div class='dropdown-menu' style="overflow-y:auto;">
<a class='dropdown-item' href='store.php'>Online Store</a>
<a class='dropdown-item' href='repairshop.php'>Repair Services</a>
<a class='dropdown-item' href=''>Security System Installation</a>
</div>
</li>
<li class='nav-item dropdown'>
<a class='nav-link dropdown-toggle' data-toggle='dropdown' href=''>Social Media</a>
<div class='dropdown-menu' style="overflow-y:auto;">
<a class='dropdown-item fa fa-facebook' href='https://www.facebook.com/clinicadelcelularmexico'></a>
<a class='dropdown-item fa fa-instagram' href='https://www.instagram.com/clinicacelularmx/'></a>
<a class='dropdown-item' href='https://api.whatsapp.com/send?phone=525510634948&fbclid=IwAR1f-PwOaB2ra3UY4LwG3s556mVBXYaz2FVhEnxWWd49aAiyl_AqP2GI_nQ'>WhatsApp</a>
</div>
</li>
<li class='nav-item'>
<a class='nav-link' href='reviews.php'>Reviews</a>
</li>
<li class='nav-item'>
<a class='nav-link' href='careers.php'>Careers</a>
</li>
</ul>
<br>
<div class='row'>
<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png" class='colordiff' style='width:75%;height:80%;background-color:MediumPurple;' title="Clinica Celular" alt="Clinica Celular"/></a></div>
<div class="col-sm-4">
<ul class="nav justify-content-center">
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='sitemap.php'>Sitemap</a>
</li>
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='recalls.php'>Recalls</a>
</li>
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='terms.php'>Terms</a>
</li>
<li class='nav-item'>
<a class='nav-link' style='font-size:75%;' href='privacy.php'>Privacy + Security</a>
</li>
</ul>
</div>
</div>
</div>
<script>$('input').after('<br>');</script>
</body>
</html>