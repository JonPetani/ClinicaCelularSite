<?php
require 'PHPAssets/connect.php';
require 'PHPAssets/accounttools.php';
require 'PHPAssets/pagetools.php';
require 'PHPAssets/submissiontools.php';
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
	if(isset($_FILES['ProductList'])) {
		echo "Success";
	}
	else if(isset($_POST['ProductInsert'])) {
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
		if(round($_POST['Price'], 2, PHP_ROUND_HALF_DOWN) <= 4.50) {
			header('Location: productupload.php?error=freeprice');
			die;
		}
		if(empty($_FILES['Images']['tmp_name'][0])) {
			header('Location: productupload.php?error=upload');
			die;
		}
		if(sizeof($_FILES['Images']['tmp_name']) > 4) {
			header('Location: productupload.php?error=limit');
			die;
		}
		$images = uploadImages($_FILES['Images']);
		if(intval($_POST['Quantity']) < 0) {
			header('Location: productupload.php?error=quantity');
			die;
		}
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