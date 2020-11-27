<?php
include "PHPAssets/connect.php";
include "PHPAssets/pagetools.php";
include "PHPAssets/accounttools.php";
isEmployee($con, decryptDisplay($_SESSION['CodeValue'], $con));
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$sql = $con -> prepare("SELECT * FROM employee WHERE AdminPassword = :admin");
	$sql -> bindParam(':admin', $_POST['ACode']);
	$sql -> execute();
	if($sql -> rowCount() == 1) {
		$_SESSION['admin'] = true;
		$admin = $sql -> fetch(PDO::FETCH_ASSOC);
		$admin_array = array('AdminPassword' => $admin_array['AdminPassword']);
		$status = encryptSet($admin_array, $con);
		header("Location: employeehome.php");
		die;
	}
	else {
		header("Location: employeehome.php?error=password");
		die;
	}
}
else {
	header("Location: employeehome.php");
	die;
}
?>