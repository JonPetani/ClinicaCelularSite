<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
require "PHPAssets/formtools.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!isset($_SESSION['CodeValue'])) {
		session_destroy();
		header("Location: employeeverify.php?error=employeeverifyfailed");
		die;
	}
	$verify_array = array("CodeValue" => decryptDisplay($_SESSION['CodeValue'], $con));
	isEmployee($con, $verify_array);
	unset($verify_array);
	$sql = $con -> prepare("SELECT * FROM employee WHERE Password = :pass");
	$sql -> bindParam(':pass', $_POST['EPassword']);
	$sql -> execute();
	if($sql -> rowCount() < 1) {
		header("Location: employeelogin.php?error=password");
		die;
	}
	$employee = $sql -> fetch(PDO::FETCH_ASSOC);
	$_SESSION['logged'] = 'loggedin';
	$_SESSION['type'] = 'employee';
	$encrypt = encryptSet($employee, $con);
}
else {
	if(!isset($_SESSION['CodeValue'])) {
		session_destroy();
		header("Location: employeeverify.php?error=employeeverifyfailed");
		die;
	}
	if(!isset($_SESSION['Password'])) {
		header("Location: employeelogin.php?error=earlylogout");
		die;
	}
	$verify_array = array("CodeValue" => decryptDisplay($_SESSION['CodeValue'], $con), "Password" => decryptDisplay($_SESSION['Password'], $con));
	isEmployee($con, $verify_array);
	unset($verify_array);
}
?>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<title>Worker Hub : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<div class="container">
<?php
setAccountTabs($con);
?>
<main>
<br clear=both>
<h1> All Set <?php echo decryptDisplay($_SESSION['FirstName'], $con);?></h1>
<p>Now that your signed in, get to work.</p>
<?php
if(isset($_SESSION['admin'])) {
	if($_SESSION['admin'] === true)
		printInfo('adminlogged', "Admin Login Sucessful");
}
if(isset($_SESSION['AdminPassword'])) {
	if(!empty($_SESSION['AdminPassword'])) {
		if(!isset($_SESSION['admin'])) {
			if(isset($employee['AdminPassword']))
				unset($employee['AdminPassword']);
			echo "<h1>This Account is Listed as an System Admin one. To get Admin Access, Enter your Administrator's Password Below</h1>";
			echo "<form action='adminlogin.php' method='POST'>";
			printError('password', 'The Admin Password Entered Was Incorrect');
			echo "<input type='password' name='ACode' placeholder='Your Administrator's Password' autocomplete='false' required/>";
			echo "<input type='submit' value='Get Admin Access Now'/>";
			echo "</form>";
		}
	}
}
?>
</main>
<script>
formSetup();
</script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>