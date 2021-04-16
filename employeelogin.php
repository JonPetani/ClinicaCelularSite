<!--
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Once The First Employee Login Page is Complete, Employees Must Enter Their Own Individual Password
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="JS/formsetup.js"></script>
<script src="JS/pagesetup.js"></script>
<title>Employee Password Login</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
require "PHPAssets/pagetools.php";
//Logged In Account Handler (Determine Where User Should Be Rerouted)
if(isset($_SESSION['logged'])) {
	if($_SESSION['logged'] == true) {
		switch($_SESSION['type']) {
			case "customer":
			$block = "Error: Restricted From Customers.";
			break;
			
			case "employee":
			header("Location: employeehome.php");
			die;
			
			default:
		    $block = "Error: Please Enter Employee Code On <a href='employeeverify.php'>This Page</a> Before Proceeding If Employee. Otherwise is Restricted.";
			break;
		}
	}
	else {
		header("Location: employeeverify.php?error=loading");
		die;
	}
}
//Check if Employee Site Code Matches with POST Input
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$sql = $con -> prepare("SELECT * FROM sitecodes WHERE CodeName = :ecode");
	$codename = "EmployeeCode";
	$sql -> bindParam(":ecode", $codename);
	$sql -> execute();
	$ecode = $sql -> fetch(PDO::FETCH_ASSOC);
	if(strcmp($_POST['Code'], $ecode['CodeValue']) != 0) {
		header("Location: employeeverify.php?error=mismatch");
		die;
	}
	$ecode_array = array('CodeValue' => $ecode['CodeValue']);
	encryptSet($ecode_array, $con);
}
//If User Inserts Wrong Employee Password This Code Keeps User From Being Sent Back To The First Login Page
else {
	if(isset($_SESSION['CodeValue'])) {
		$sql = $con -> prepare("SELECT * FROM sitecodes WHERE CodeValue = :ecode");
		$value = decryptDisplay($_SESSION['CodeValue'], $con);
		$sql -> bindParam(":ecode", $value);
		$sql -> execute();
		if($sql -> rowCount() < 1) {
			header("Location: employeeverify.php?error=mismatch");
			die;
		}
	}
	else {
		header("Location: employeeverify.php?error=nodata");
		die;
	}
}
?>
<div class="container" style='background-color:CornFlowerBlue;'>
<div class="container" style='background-color:DarkSlateBlue;'>
<?php
setAccountTabs($con);
?>
</div>
<div class='container bg-primary text-white'>
<h1>Employee Verification Successful. Simply enter your Employee information to get access to your Account</h1>
<!--Form To Insert The Employee's Personal Password-->
<form action="employeehome.php" method="POST">
<?php
printError("password", "Wrong Password");
printError("earlylogout", "Password Wasn't Logged Properly. Re-Login To Get Back In");
?>
<label for='EPassword'>
<a href='ForgotEmployee.php' class='text-white'>Forgot Your Employee User Password?</a>
</label>
<input name="EPassword" type="password" class='form-control' placeholder="Your Employee Password" required autocomplete="false"/>
<input type="submit" value="Log On"/>
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