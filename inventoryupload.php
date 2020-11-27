<?php
require 'PHPAssets/connect.php';
require 'PHPAssets/accounttools.php';
require 'PHPAssets/pagetools.php';
isEmployee($con, decryptDisplay($_SESSION['CodeValue'], $con));
if($_SERVER['REQUEST_METHOD'] == "POST") {
	if(isset($_FILE['ProductList'])) {
		echo $_FILE['ProductList']['type'];
		/*switch() {	
		}*/
	}
	else {
		header("productinventory.php?error=nofile");
		die;
	}
}
else {
	header("productinventory.php?error=nosubmit")
	die;
}
?>