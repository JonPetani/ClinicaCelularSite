<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
</head>
<title>Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
isEmployee($con, decryptDisplay($_SESSION['CodeValue'], $con));
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id="register">Register Account</a>
<a href="login.php" id="login">Log In</a>
<?php
setAccountTabs();
?>
</nav>
<br clear=both>
<main>
<br>
<h1>Here you can manage our Store Inventory based on what we got in stock.</h1>
<p>View the List below first and review it against what company documents or you see as the actual stock of item(s)</p>
<br>
<p>Below Is our current product list with the price and quantity in stock noted. If a item is no longer offered at the company or info is incorrect you can edit it directly:</p>
<table>
<?php
$sql = $con -> prepare("SELECT * FROM product");
$sql -> execute();
if($sql -> rowCount() > 0 ) {
$products = $sql -> fetchAll(PDO::FETCH_ASSOC);
	for($i = 0; $i < sizeof($products);) {
		echo"<tr>";
		for($j = 0; $j < 5; $j++) {
			echo"<td>";
			printf("Product Name: %s\n", $products['ProductName']);
			printf("Product Description: %s\n", $products['ProductDescription']);
			printf("Set Price: %f\n", $products['Price']);
			printf("Product Description: %s\n", $products['ProductDescription']);
			printf("How Many of this We Got In Stock: %d", $products['Quantity']);
			printf("Product Code: %s", $products['ItemCode']);
			printf("<img src=\'%s\' title=\'%s\' alt=\'Placeholder Text For %s Product\'/>", $products['ItemDescription']);
			printf("What Category of Product is it: %s", $products['Category']);
			echo"</td>";
			$i++;
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
<?php
?>
<div class='selector'>
<form action="inventoryupload.php" enctype="multipart/form-data" method="POST">
<input type="file" name="ProductList" required autocomplete="false">Upload Document(s) Here</input>
</form>
<a href="productupload.php">Or Insert A Product Manually Here</a>
</div>
<br clear=both>
</main>
<script>
fileUploadAction();
</script>
</body>
</html>