<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Upload The Product(s) From Either The Product Upload form at productupload.php or By a Uploaded Spreadsheet
*/
require 'PHPAssets/connect.php';
require 'PHPAssets/accounttools.php';
require 'PHPAssets/pagetools.php';
require 'PHPAssets/submissiontools.php';
//Verify Uploader Is A Employee
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
if($_SERVER['REQUEST_METHOD'] == "POST") {
	//Quick Test Of File Upload (Experimental/Would Use Zip Libraries)
	if(isset($_FILES['ProductList'])) {
		echo "Success";
	}
	//Product Upload via Product Upload Form
	else if(isset($_POST['ProductInsert'])) {
		//Make sure each String of POST data is lengthy enough and accurate
		if(strlen($_POST['Name']) < 14) {
			header('Location: productupload.php?error=name');
			die;
		}
		if(strlen($_POST['Description']) < 20) {
			header('Location: productupload.php?error=desc');
			die;
		}
		if(strlen($_POST['Brand']) < 3) {
			header('Location: productupload.php?error=brand');
			die;
		}
		if(floatval($_POST['Price']) == 0 or floatval($_POST['Price']) == 1) {
			header('Location: productupload.php?error=price');
			die;
		}
		//For these the round function converts to the dollar + cents format in case the float had 3+ places
		if(round($_POST['Price'], 2, PHP_ROUND_HALF_DOWN) <= 4.50) {
			header('Location: productupload.php?error=freeprice');
			die;
		}
		//If Files Array of Images is empty or larger than the 4 image upload limit printError and go back
		if(empty($_FILES['Images']['tmp_name'][0])) {
			header('Location: productupload.php?error=upload');
			die;
		}
		if(sizeof($_FILES['Images']['tmp_name']) > 4) {
			header('Location: productupload.php?error=limit');
			die;
		}
		//The Upload of the Images to ImgBB and return of the proper url's to view them
		$images = uploadImages($_FILES['Images']);
		if(intval($_POST['Quantity']) < 0) {
			header('Location: productupload.php?error=quantity');
			die;
		}
		//Will only accept results that match one of the enum strings defined in the DB for the column
		if(strcmp($_POST['Category'], 'Desktop') != 0 and strcmp($_POST['Category'], 'PC') != 0 and strcmp($_POST['Category'], 'Tablet') != 0 and strcmp($_POST['Category'], 'Celular') != 0 and strcmp($_POST['Category'], 'Phone') != 0 and strcmp($_POST['Category'], 'Security') != 0) {
			header('Location: productupload.php?error=wrongselect1');
			die;
		}
		if(strcmp($_POST['ProductType'], 'Hardware') != 0 and strcmp($_POST['ProductType'], 'Software') != 0 and strcmp($_POST['ProductType'], 'Electronic') != 0 and strcmp($_POST['ProductType'], 'Misc') != 0 and strcmp($_POST['ProductType'], 'Accessory') != 0) {
			header('Location: productupload.php?error=wrongselect2');
			die;
		}
		if(floatval($_POST['Cost']) == 0 or floatval($_POST['Cost']) == 1) {
			header('Location: productupload.php?error=cost');
			die;
		}
		if(round($_POST['Cost'], 2, PHP_ROUND_HALF_DOWN) <= 2.50) {
			header('Location: productupload.php?error=costfree');
			die;
		}
		if(round($_POST['Cost'], 2, PHP_ROUND_HALF_DOWN) > round($_POST['Price'], 2, PHP_ROUND_HALF_DOWN)) {
			header('Location: productupload.php?error=profits');
			die;
		}
		if(intval($_POST['InPackage']) < 1) {
			header('Location: productupload.php?error=loss');
			die;
		}
		$not_duplicate = false;
		//Generates a unique Item Code / Product ID For the Product that can be used in search queries on site
		do {
			$item_code = randomCodeGenerator(9, 13);
			$check = $con -> prepare("SELECT * FROM product WHERE ItemCode = :icode");
			$check -> bindParam(':icode', $item_code);
			$check -> execute();
			if($check -> rowCount() > 0)
				$not_duplicate = false;
			else
				$not_duplicate = true;
		} while($not_duplicate == false);
		//Insert Product (For Images the space seperated list of urls will be uploaded)
		$insert = $con -> prepare("INSERT INTO product(ProductName, ProductDescription, Brand, Price, Quantity, ItemCode, ProductImage, Category, ProductType, Cost, InPackage) VALUES (:product, :desc, :brand, :price, :quantity, :code, :img, :cat, :type, :cost, :inp)");
		$insert -> bindParam('product', $_POST['Name']);
		$insert -> bindParam('desc', $_POST['Description']);
		$insert -> bindParam('brand', $_POST['Brand']);
		$insert -> bindParam('price', $_POST['Price']);
		$insert -> bindParam('quantity', $_POST['Quantity']);
		$insert -> bindParam('code', $item_code);
		$insert -> bindParam('img', $images);
		$insert -> bindParam('cat', $_POST['Category']);
		$insert -> bindParam('type', $_POST['ProductType']);
		$insert -> bindParam('cost', $_POST['Cost']);
		$insert -> bindParam('inp', $_POST['InPackage']);
		$insert -> execute();
		header('Location: productupload.php?info=uploaded');
		die;
	}
	else {
		header("Location: productupload.php?error=loading");
		die;
	}
}
else {
	header("Location: productinventory.php?error=nosubmit");
	die;
}
?>