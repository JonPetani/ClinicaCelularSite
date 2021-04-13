<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<title>Our Inventory : Clínica Celular</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/formtools.php";
?>
<div class="container">
<?php
setAccountTabs($con);
?>
<br clear=both>
<main>
<br>
<h1>Our Store Sells Many Electronics Products</h1>
<?php printError("noproduct", "Product Information Loading Failed. Either URL was damaged or db failed. Please Try Again Using The Original Link or Contact Support.");?>
<div id='search' class='storepage' style="float:left;width:35%;">
<?php printError("tag", "Search Query Failed. Make sure URL isn't altered from what the link goes to. Otherwise, report the error to tech support.");?>
<h4>Search By Name</h4>
<form action='store.php?action=search'>
<input type='text' name='SearchQuery' id='sortbar' onfocus='searchBarHelpText(this)' onfocusout='searchBarDefaultText(this)' placeholder='Find a Product' required autocomplete='false'>
</form>
<script>
searchBarAction();
</script>
<br>
<h4>Search By Electronic</h4>
<?php
$category_links = array('PC', 'Tablet', 'Desktop', 'Phone', 'Celular', 'Security');
for($i = 0; $i < sizeof($category_links); $i++) {
	$category_str = 'store.php';
	if(isset($_GET['Brand'])) {
		if(strpos($category_str, '?') == false)
			$category_str = $category_str . "&Brand=" . $_GET['Brand'];
		else
			$category_str = $category_str . "?Brand=" . $_GET['Brand'];
	}
	if(isset($_GET['Type'])) {
		if(strpos($category_str, '?') == false)
			$category_str = $category_str . "&Type=" . $_GET['Type'];
		else
			$category_str = $category_str . "?Type=" . $_GET['Type'];
	}
	if(isset($_GET['Cat'])) {
		if(strcmp($_GET['Cat'], $category_links[$i]) != 0) {
			if(strpos($category_str, '?') != false)
				$category_str = $category_str . "&Cat=" . $category_links[$i];
			else
				$category_str = $category_str . "?Cat=" . $category_links[$i];
			$checkbox = "&#9744;";
		}
		else
			$checkbox = "&#9745;";
	}
	else {
		if(strpos($category_str, '?') != false)
			$category_str = $category_str . "&Cat=" . $category_links[$i];
		else
			$category_str = $category_str . "?Cat=" . $category_links[$i];
		$checkbox = "&#9744;";
	}
	printf("<a href='%s'>%s %s</a><br> ", $category_str, $checkbox, $category_links[$i]);
}
?>
<br>
<h4>Search By Product Usage</h4>
<?php

$product_links = array('Electronic', 'Hardware', 'Software', 'Accessory', 'Misc');
for($i = 0; $i < sizeof($product_links); $i++) {
	$product_str = 'store.php';
	if(isset($_GET['Brand'])) {
		if(strpos($product_str, '?') == false)
			$product_str = $product_str . "&Brand=" . $_GET['Brand'];
		else
			$product_str = $product_str . "?Brand=" . $_GET['Brand'];
	}
	if(isset($_GET['Cat'])) {
		if(strpos($product_str, '?') == false)
			$product_str = $product_str . "&Cat=" . $_GET['Cat'];
		else
			$product_str = $product_str . "?Cat=" . $_GET['Cat'];
	}
	if(isset($_GET['Type'])) {
		if(strcmp($_GET['Type'], $product_links[$i]) != 0) {
			if(strpos($product_str, '?') != false)
				$product_str = $product_str . "&Type=" . $product_links[$i];
			else
				$product_str = $product_str . "?Type=" . $product_links[$i];
			$checkbox = "&#9744;";
		}
		else
			$checkbox = "&#9745;";
	}
	else {
		if(strpos($product_str, '?') != false)
			$product_str = $product_str . "&Type=" . $product_links[$i];
		else
			$product_str = $product_str . "?Type=" . $product_links[$i];
		$checkbox = "&#9744;";
	}
	printf("<a href='%s'>%s %s</a><br> ", $product_str, $checkbox, $product_links[$i]);
}
?>
<br>
<h4>Search By Brand</h4>
<?php
$brand_names = $con -> prepare('SELECT DISTINCT Brand FROM product');
$brand_names -> execute();
$brand_links = $brand_names -> fetchAll(PDO::FETCH_ASSOC);
for($i = 0; $i < sizeof($brand_links); $i++) {
	$brand_str = 'store.php';
	if(isset($_GET['Cat'])) {
		if(strpos($brand_str, '?') == false)
			$brand_str = $brand_str . "&Cat=" . $_GET['Cat'];
		else
			$brand_str = $brand_str . "?Cat=" . $_GET['Cat'];
	}
	if(isset($_GET['Type'])) {
		if(strpos($brand_str, '?') == false)
			$brand_str = $brand_str . "&Type=" . $_GET['Type'];
		else
			$brand_str = $brand_str . "?Type=" . $_GET['Type'];
	}
	if(isset($_GET['Brand'])) {
		if(strcmp($_GET['Brand'], $brand_links[$i]['Brand']) != 0) {
			if(strpos($brand_str, '?') != false)
				$brand_str = $brand_str . "&Brand=" . $brand_links[$i]['Brand'];
			else
				$brand_str = $brand_str . "?Brand=" . $brand_links[$i]['Brand'];
			$checkbox = "&#9744;";
		}
		else
			$checkbox = "&#9745;";
	}
	else {
		if(strpos($brand_str, '?') != false)
			$brand_str = $brand_str . "&Brand=" . $brand_links[$i]['Brand'];
		else
			$brand_str = $brand_str . "?Brand=" . $brand_links[$i]['Brand'];
		$checkbox = "&#9744;";
	}
	printf("<a href='%s'>%s %s</a><br> ", $brand_str, $checkbox, $brand_links[$i]['Brand']);
}
?>
<br clear=both>
</div>
<br>
<div id='items' class='storepage' style="float:left;width:65%;">
<table>
<?php
/*if(isset($_GET['action'])) {
	if(strcmp($_GET['action'], 'search') == 0) {
		$search_query = $_GET['action'];
		
	}
}*/
if(isset($_GET['Cat'])) {
	if(!empty($_GET['Cat']))
		$category = $_GET['Cat'];
}
if(isset($_GET['Type'])) {
	if(!empty($_GET['Type']))
		$type = $_GET['Type'];
}
if(isset($_GET['Brand'])) {
	if(!empty($_GET['Brand']))
		$brand = $_GET['Brand'];
}
$query_str = "SELECT * FROM product";

if(isset($category)) {
	if(strpos($query_str, "WHERE") === false)
		$query_str = $query_str . " WHERE";
	else
		$query_str = $query_str . " AND";
	$query_str = $query_str . " Category = :cat";
}
if(isset($type)) {
	if(strpos($query_str, "WHERE") === false)
		$query_str = $query_str . " WHERE";
	else
		$query_str = $query_str . " AND";
	$query_str = $query_str . " ProductType = :type";
}
if(isset($brand)) {
	if(strpos($query_str, "WHERE") === false)
		$query_str = $query_str . " WHERE";
	else
		$query_str = $query_str . " AND";
	$query_str = $query_str . " Brand = :brand";
}
$product = $con -> prepare($query_str);
if(isset($category))
	$product -> bindParam(':cat', $category);
if(isset($type))
	$product -> bindParam(':type', $type);
if(isset($brand))
	$product -> bindParam(':brand', $brand);
$product -> execute();
$pcount = $product -> rowCount();
if($pcount > 52) {
	if(!isset($_GET['Range'])) {
		$query_str = $query_str . " LIMIT 0 52";
	}
	else {
		$range = strval(0 + 51 * $_GET['Range']);
		$query_str = $query_str . " LIMIT " . $range . " 52";
	}
	$product = $con -> prepare($query_str);
	if(isset($category))
		$product -> bindParam(':cat', $category);
	if(isset($type))
		$product -> bindParam(':type', $type);
	if(isset($brand))
		$product -> bindParam(':brand', $brand);
	$product -> execute();
}
$items = $product -> fetchAll(PDO::FETCH_ASSOC);
for($i = 0; $i < sizeof($items);) {
	echo "<tr>";
	for($j = 0; $j < 4; $j++) {
		$image_set = explode(" ", $items[$i]['ProductImage']);
		echo"<td>";
		$dimensions = 'width:200px;height:200px;padding: 0px 10px 0px 10px';
		printf("<a href='productview.php?product=%s&imgset=0'><img src='%s' style='%s' id='%s' title='%s' alt='%s'/></a>", $items[$i]['ProductName'], $image_set[0], $dimensions, $items[$i]['ProductName'], $items[$i]['ProductName'], "Image For " . $items[$i]['ProductName']);
		echo"<br>";
		printf("<a href='productview.php?product=%s'&imgset=0>%s</a>", $items[$i]['ProductName'], $items[$i]['ProductName']);
		echo"<br>";
		printf("<strong>$%.2f</strong>", $items[$i]['Price']);
		echo"<br>";
		printf("<a href=cartmanage.php>Add To Cart</a>");
		if(sizeof($image_set) > 1) {
			echo'<script>';
			printf("$('img#%s').mouseenter(function(){", $items[$i]['ProductImage']);
			printf("$(this).attr('src', '%s');", $image_set[1]);
			echo"});";
			printf("$('img#%s').mouseleave(function(){", $items[$i]['ProductImage']);
			printf("$(this).attr('src', '%s');", $image_set[0]);
			echo"});";
			echo'</script>';
		}
		echo "</td>";
		$i++;
		if($i == sizeof($items)) {
			break;
		}
	}
	echo "</tr>";
}
?>
</table>
</div>
<br clear=both>
<div id="ShopNav" align=center>
<?php
$base_url = 'store.php';
if(isset($_GET['Cat'])) {
	if(strpos($base_url, '?') == false)
		$base_url = $base_url . "&Cat=" . $_GET['Cat'];
	else
		$base_url = $base_url . "?Cat=" . $_GET['Cat'];
}
if(isset($_GET['Type'])) {
	if(strpos($base_url, '?') == false)
		$base_url = $base_url . "&Type=" . $_GET['Type'];
	else
		$base_url = $base_url . "?Type=" . $_GET['Type'];
}
if(isset($_GET['Brand'])) {
	if(strpos($base_url, '?') == false)
		$base_url = $base_url . "&Brand=" . $_GET['Brand'];
	else
		$base_url = $base_url . "?Brand=" . $_GET['Brand'];
}
$total = round($pcount / 52) + 1;
if(isset($_GET['Range'])) {
	if(intval($_GET['Range']) > 0) {
		if(strpos($base_url, '?') == false)
			$prange = "&Range=" . strval(intval($_GET['Range']) - 1);
		else
			$prange = "?Range=" . strval(intval($_GET['Range']) - 1);
		printf("<a href='%s%s'>&larr;</a>", $base_url, $prange);
	}
	printf("<h4>Page %s Of %s</h4>", strval(intval($_GET['Range']) + 1), strval($total));
	if(intval($_GET['Range']) < $total) {
		if(strpos($base_url, '?') == false)
			$prange = "&Range=" . strval(intval($_GET['Range']) + 1);
		else
			$prange = "?Range=" . strval(intval($_GET['Range']) + 1);
		printf("<a href='%s%s'>&rarr;</a>", $base_url, $prange);
	}
}
else {
	printf("<h4 style='margin:auto;'>Page %s Of %s</h4>", '1', strval($total));
	if($pcount > 52) {
		if(strpos($base_url, '?') == false)
			$prange = "&Range=2";
		else
			$prange = "?Range=2";
		printf("<a href='%s%s'>&rarr;</a>", $base_url, $prange);
	}
}
?>
</div>
<br clear=both>
</main>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>