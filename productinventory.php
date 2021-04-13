<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/pagesetup.js"></script>
<script src="JS/formsetup.js"></script>
</head>
<title>Clínica Celular : Inventory View</title>
<link href="Images/TabImg.png" rel="icon"/>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
require "PHPAssets/formtools.php";
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
if(isset($_GET['action']) and isset($_GET['product'])) {
	switch($_GET['action']) {
		case 'delete':
		$sql = $con -> prepare("SELECT * FROM product WHERE ProductName = :delname");
		$sql -> bindParam(':delname', $_GET['product']);
		$sql -> execute();
		if($sql->rowCount() == 0)
			errorPageDisplay("Product Does Not Exist In Our System. Make Sure URL Matches That of The Link. Otherwise, Report to a Co-Worker Working On This Site. If You Are One Of These, You Know What To Do.");
		$sql = $con -> prepare("DELETE FROM product WHERE ProductName = :delname");
		$sql -> bindParam(':delname', $_GET['product']);
		$sql -> execute();
		printInfo("delete", "Product Deleted Successfully");
		break;
		
		case 'edit':
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			$sql = $con -> prepare("SELECT * FROM product WHERE ProductName = :editname");
			$sql -> bindParam(':editname', $_GET['product']);
			$sql -> execute();
			if($sql->rowCount() == 0)
				errorPageDisplay("Product Does Not Exist In Our System. Make Sure URL Matches That of The Link. Otherwise, Report to a Co-Worker Working On This Site. If You Are One Of These, You Know What To Do.");
			$old_info = $sql -> fetch(PDO::FETCH_ASSOC);
			$base_query = "UPDATE product SET ";
			if(strcmp($_POST['Name'], "") != 0) {
				if(strlen($_POST['Name']) < 14) {
					header('Location: editproduct.php?error=name&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "ProductName = :name";
			}
			if(strcmp($_POST['Description'], "") != 0) {
				if(strlen($_POST['Description']) < 20) {
					header('Location: editproduct.php?error=desc&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "ProductDescription = :desc";
			}
			if(strcmp($_POST['Brand'], "") != 0) {
				if(strlen($_POST['Brand']) < 3) {
					header('Location: editproduct.php?error=brand&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "Brand = :brand";
			}
			if(strcmp(strval($_POST['Price']), "") != 0) {
				if(floatval($_POST['Price']) == 0 or floatval($_POST['Price']) == 1) {
					header('Location: editproduct.php?error=price&product=' . $_GET['product']);
					die;
				}
				if(round($_POST['Price'], 2, PHP_ROUND_HALF_DOWN) <= 4.50) {
					header('Location: editproduct.php?error=freeprice&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "Price = :price";
			}
			if(strcmp(strval($_POST['Quantity']), "") != 0) {
				if(intval($_POST['Quantity']) < 0) {
					header('Location: editproduct.php?error=quantity&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "Quantity = :quant";
			}
			if(!empty($_FILES['Images']['tmp_name'][0])) {
				if(sizeof($_FILES['Images']['tmp_name']) > 4) {
					header('Location: editproduct.php?error=limit&product=' . $_GET['product']);
					die;
				}
				$images = $old_info['ProductImage'] . " " . uploadImages($_FILES['Images']);
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "ProductImage = :img";
			}
			if(strcmp($_POST['Category'], "None") != 0) {
				if(strcmp($_POST['Category'], 'Desktop') != 0 and strcmp($_POST['Category'], 'PC') != 0 and strcmp($_POST['Category'], 'Tablet') != 0 and strcmp($_POST['Category'], 'Celular') != 0 and strcmp($_POST['Category'], 'Phone') != 0 and strcmp($_POST['Category'], 'Security') != 0) {
					header('Location: editproduct.php?error=wrongselect1&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "Category = :cat";
			}
			if(strcmp($_POST['ProductType'], "None") != 0) {
				if(strcmp($_POST['ProductType'], 'Hardware') != 0 and strcmp($_POST['ProductType'], 'Software') != 0 and strcmp($_POST['ProductType'], 'Electronic') != 0 and strcmp($_POST['ProductType'], 'Misc') != 0 and strcmp($_POST['ProductType'], 'Accessory') != 0) {
					header('Location: editproduct.php?error=wrongselect2&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "ProductType = :type";
			}
			if(strcmp(strval($_POST['Cost']), "") != 0) {
				if(round($_POST['Cost'], 2, PHP_ROUND_HALF_DOWN) <= 2.50) {
					header('Location: editproduct.php?error=costfree&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "Price") == false)
					$price_cmp = $old_info['Price'];
				else
					$price_cmp = $_POST['Price'];
				if(round($_POST['Cost'], 2, PHP_ROUND_HALF_DOWN) > round($price_cmp, 2, PHP_ROUND_HALF_DOWN)) {
					header('Location: editproduct.php?error=profits&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "Cost = :cost";
			}
			if(strcmp(strval($_POST['InPackage']), "") != 0) {
				if(intval($_POST['InPackage']) < 1) {
					header('Location: editproduct.php?error=loss&product=' . $_GET['product']);
					die;
				}
				if(strpos($base_query, "=") != false)
					$base_query = $base_query . ", ";
				$base_query = $base_query . "InPackage = :inpack";
			}
			$base_query = $base_query . " WHERE ProductName = :prod";
			$sql = $con -> prepare($base_query);
			if(strpos($base_query, "ProductName = :name") != false)
				$sql -> bindParam(':name', $_POST['Name']);
			if(strpos($base_query, "ProductDescription") != false)
				$sql -> bindParam(':desc', $_POST['Description']);
			if(strpos($base_query, "Brand") != false)
				$sql -> bindParam(':brand', $_POST['Brand']);
			if(strpos($base_query, "Price") != false)
				$sql -> bindParam(':price', $_POST['Price']);
			if(strpos($base_query, "ProductImage") != false)
				$sql -> bindParam(':img', $images);
			if(strpos($base_query, "Quantity") != false)
				$sql -> bindParam(':quant', $_POST['Quantity']);
			if(strpos($base_query, "Category") != false)
				$sql -> bindParam(':cat', $_POST['Category']);
			if(strpos($base_query, "ProductType") != false)
				$sql -> bindParam(':type', $_POST['ProductType']);
			if(strpos($base_query, "Cost") != false)
				$sql -> bindParam(':cost', $_POST['Cost']);
			if(strpos($base_query, "InPackage") != false)
				$sql -> bindParam(':inpack', $_POST['InPackage']);
			$sql -> bindParam(':prod', $_GET['product']);
			$sql -> execute();
		}
		break;
	}
}
?>
<div class="container">
<?php
setAccountTabs($con);
?>
<br clear=both>
<main>
<br>
<h1>Here you can manage our Store Inventory based on what we got in stock.</h1>
<p>View the List below first and review it against what company documents or you see as the actual stock of item(s)</p>
<br>
<p>Below Is our current product list with the price and quantity in stock noted. If a item is no longer offered at the company or info is incorrect you can edit it directly:</p>
<table class='data'>
<?php
$sql = $con -> prepare("SELECT * FROM product");
$sql -> execute();
if($sql -> rowCount() > 0 ) {
$products = $sql -> fetchAll(PDO::FETCH_ASSOC);
	for($i = 0; $i < sizeof($products);) {
		echo"<tr>";
		for($j = 0; $j < 5; $j++) {
			echo"<td>";
			printf("<p>Product Name: %s</p>", $products[$i]['ProductName']);
			printf("<p>Product Description: %s</p>", $products[$i]['ProductDescription']);
			printf("<p>Product Brand: %s\n</p>", $products[$i]['Brand']);
			printf("<p>Set Price: $%f\n</p>", $products[$i]['Price']);
			printf("<p>Cost To Purchase From Vendor: $%f</p>", $products[$i]['Cost']);
			printf("<p>Product Description: %s</p>", $products[$i]['ProductDescription']);
			printf("<p>How Many of this We Got In Stock: %d</p>", $products[$i]['Quantity']);
			printf("<p>How Much Units Are In Each Package (To Ensure Product Quality): %d</p>", $products[$i]['InPackage']);
			printf("<p>Product Code: %s</p>", $products[$i]['ItemCode']);
			printf("<p>Electronic That Is For: %s</p>", $products[$i]['Category']);
			printf("<p>Type Of Product That It Is: %s</p>", $products[$i]['ProductType']);
			echo"<p>Images Uploaded For This Product: </p>";
			$image_set = explode(" ", $products[$i]['ProductImage']);
			print_r($image_set);
			foreach($image_set as $image_url) {
				$dimensions = "width:10%;height:10%;float:left;";
				printf("<img src='%s' style='%s' title='Image View Of %s' alt='Placeholder Text For %s Product'/>", $image_url, $dimensions, $products[$i]['ProductName'], $products[$i]['ProductDescription']);
			}
			echo"<br clear=both>";
			printf("<a href='editproduct.php?product=%s' style='float:left;'>&#9986; Edit Product</a>", $products[$i]['ProductName']);
			printf("<a href='productinventory.php?action=delete&product=%s&info=delete' style='float:left;'>&#9746; Delete Product</a>", $products[$i]['ProductName']);
			echo"<br clear=both>";
			printError('missing', 'Missing URL Info. Make Sure URL Matches That of The Link. Otherwise, Report to a Co-Worker Working On This Site. If You Are One Of These, You Know What To Do.');
			printError('noproduct', 'Product Does Not Exist In Our System. Make Sure URL Matches That of The Link. Otherwise, Report to a Co-Worker Working On This Site. If You Are One Of These, You Know What To Do.');
			printInfo('edited', "Product Successfully Updated. Review The Information as Needed if Additonal Changes are Needed");
			echo"</td>";
			$i++;
			if($i == sizeof($products))
				break;
		}
		echo"</tr>";
	}
}
else {
	echo"Currently No Products are Listed as none have been uploaded. Take care of this below by adding them.";
}
?>
</table>
<br>
<p>If something is missing from the inventory you can add a item manually or if there are multiple items missing you can upload a file.</p>
<div class='selector'>
<form action="inventoryupload.php" enctype="multipart/form-data" multiple method="POST">
<?php
printError("nosubmit", "File(s) Not Submitted");
?>
<input type="file" name="ProductList" required autocomplete="false">Upload Document(s) Here</input>
</form>
<a href="productupload.php">Or Insert A Product Manually Here</a>
</div>
<br clear=both>
</main>
<script>
fileUploadAction();
//dataTableSetup();
</script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>