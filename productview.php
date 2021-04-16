<!--
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: View More Details About A Given Product Before Adding To Cart
-->
<html>
<head>
<link href="CSS/main.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="JS/formsetup.js"></script>
<script src="JS/pagesetup.js"></script>
<title>Our Inventory : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/formtools.php";
?>
<nav align=center>
<a href="Home.php">Home</a>
<a href="">Tech Services</a>
<a href="store.php">Online Tech Shop</a>
<a href="about.php">About Us</a>
<a href="">Contact Us</a>
<a href="register.php" id='register'>Register Account</a>
<a href="login.php" id='login'>Log In</a>
<?php
setAccountTabs();
?>
</nav>
<br clear=both>
<main>
<?php
if(isset($_GET['product'])) {
	//Iff Product Exists, Get The Needed Information
	if(!empty($_GET['product'])) {
		$product = $con -> prepare("SELECT * FROM product WHERE ProductName = :name");
		$product -> bindParam(':name', $_GET['product']);
		$product -> execute();
		if($product -> rowCount() != 1)
			errorPageDisplay("Product Not Found. Make Sure URL Matches One Provided By Product Link");
		$product_info = $product -> fetch(PDO::FETCH_ASSOC);
	}
	else {
		header("Location: store.php?error=noproduct");
		die;
	}
}
else {
	header("Location: store.php?error=noproduct");
	die;
}
?>
<!--Product Image View Div-->
<div style="float:left;width:15%;">
<?php
//Set The List of Images Assosiated with The Product
//User Rolls Over A Image To Change the Main one in the Center Div (If More Than 4 Exist, Use Arrow Button to Flip To Next Set)
$images = explode(" ", $product_info['ProductImage']);
if(isset($_GET['imgset'])) {
	$start = intval($_GET['imgset']) * 3;
	if($start > 0)
		printf("<a href='productview.php?product=%s&imgset=%s' class='imgnav'>&uarr;</a>", $_GET['product'], strval(intval($_GET['imgset']) - 1));
	for($i = $start; $i < $start + 4; $i++) {
		if($i + $start == sizeof($images))
			break;
		$dimensions = "width:150px;height:150px;";
		printf("<img src='%s' style='%s' class='viewPointer' title='Image %d' alt='%s' onmouseover='setImagePointer(this)'/><br>", $images[$i], $dimensions, $start + 1, $product_info['ProductName']);
	}
	$current = $start + 3;
}
else {
	for($i = 0; $i < 4; $i++) {
		if($i == sizeof($images))
			break;
		printf("<img src='%s' class='viewPointer' title='Image %d' alt='%s'/>", $images[$i], $i + 1, $product_info['ProductName']);
		$current = $i;
	}
	
}
if($current + 1 < sizeof($images)) {
	printf("<a href='productview.php?product=%s&imgset=%s' class='imgnav'>&darr;</a>", $_GET['product'], strval(intval($_GET['imgset']) + 1));
}
?>
</div>
<!--Main Image Div (Determined By Image List To Left Div)-->
<div style="float:left;width:40%;">
<?php
printf("<img src='%s' id='currentImage' title='Image %d' alt='%s'/>", $images[$start], $start + 1, $product_info['ProductName']);
?>
</div>
<!--Product Info-->
<div style="float:left;width:45%;">
<?php
if($product_info['Quantity'] <= 0)
	echo "<p>This Product Is Currently Out of Stock</p>";
else
	echo "<p>This Product Is Available To Order</p>";
?>
</div>
<br clear=both>
<!--Product Review Form-->
<h1>Like the Product? Write a Review!</h1>
<div id='reviews'>
<form action='<?php printf('productview.php?product=%s&imgset=%s&action=sendreview', $_GET['product'], $_GET['imgset']);?>'>
<p>Give Us Your Rating on the Product</p>
<label for='rating1'>1</label>
<input type='radio' name='rating1'/>
<label for='rating2'>2</label>
<input type='radio' name='rating2'/>
<label for='rating3'>3</label>
<input type='radio' name='rating3'/>
<label for='rating4'>4</label>
<input type='radio' name='rating4'/>
<label for='rating5'>5</label>
<input type='radio' name='rating5'/>
<textarea name='reviewText' placeholder='Tell Us What You Think About This Product'></textarea>
<input type='submit' name='Submit Review'/>
</form>
</div>
</main>
<script>
//setImagePointer();
//formSetup();
</script>
</body>
</html>