<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
<script src="JS/formsetup.js"></script>
<script src="JS/pagesetup.js"></script>
<title>Employee Verification</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/formtools.php";
require "PHPAssets/dir.php";
if(isset($_GET['action'])) {
	switch($_GET['action']) {
		case 'verify':
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sql = $con -> prepare("SELECT * FROM employee WHERE EmailAddress = :email");
			$sql -> bindParam(':email', $_GET['account']);
			$sql -> execute();
			$account = $sql -> fetch(PDO::FETCH_ASSOC);
			if(strcmp($account['VerifyCode'], $_POST['Code']) != 0) {
				$url = "VerifyAccount.php?account=" . urlencode($_GET['account']) . "&type=recoveryemployee";
				header("Location: " . $url);
				die;
			}
		}
		break;
	}
}
$verify_code = getEmployeeCodeAccess($con);
unset($verify_code);
adminPopulate($con);
?>
<div class="container" style='background-color:CornFlowerBlue;'>
<div class="container" style='background-color:DarkSlateBlue;'>
<?php
setAccountTabs($con);
?>
</div>
<div class='container bg-primary text-white'>
<div class='container bg-warning'>
<h2>This Page and Points Beyond Are Restricted to Employees</h2>
<p>Is protected by a security code. If you forgot it and didn't take note of it, press the button below to have it sent to your company email. Also check your inbox for possible changes in the code.</p>
</div>
<form action="employeelogin.php" class='bigform' method="POST">
<?php
printInfo("emailsent", "Recovery Email Sent");
printError("nodata", "No Employee Code Provided Before Entry Was Authorized. Please Enter It Below.-");
printError("mismatch", "Code Doesn't Match The Site's Employee Code. Try Again or Request it through the Account Recovery Tool Above.");
printError("employeeverifyfailed", "Only Employee's can view this content. If this is a error, relogin below.");
printInfo("logout", "Logged Out Successfully");
if(isset($verified)) {
	if($verified == true) {
		$code = getEmployeeCodeAccess($con);
		printInfo("ecode", "The Code of Employee Entry is " . $code . ".Make sure not to forget it this time.");
	}
}
?>
<label for='Code'>
<a href="employeerecovery.php" class='text-white' id="sms">Forgot The Employee Login Code?</a>
</label>
<input type="password" class='form-control' name="Code" placeholder="Enter The Employee Code" required autocomplete="false">
<input type="submit" value="Submit Code"/>
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