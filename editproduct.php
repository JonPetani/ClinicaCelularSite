<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Edit Already Uploaded Product in System</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
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
if(!isset($_GET['product'])) {
	header("Location: productinventory.php?error=missing");
	die;
}
$sql = $con -> prepare("SELECT * FROM product WHERE ProductName = :pname");
$sql -> bindParam(':pname', $_GET['product']);
$sql -> execute();
if($sql->rowCount() == 0) {
	header("Location: productinventory.php?error=noproduct");
	die;
}
$product = $sql -> fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
<?php
setAccountTabs($con);
?>
<main align=center>
<br clear=both>
<h1>Add a New Product to the Site</h1>
<form action="productinventory.php?action=edit&info=edited&product=<?php echo $product['ProductName'];?>" method="POST" enctype="multipart/form-data">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("duplicate", "Product Already Exists, Check <ah href='productinventory.php'>this page</a> to Find It");
printError("bug", "A bug occured during a site operation. Try Submitting Again");
printError("name", "Invalid Product Name Input");
echo "<label for='Name'>Edit Product Name. Current Product Name: " . $product['ProductName'] . "</label>";
?>
<input name="Name" type="text" placeholder="Change Listed Product Name Here" autocomplete="false"/>
<?php 
printError("desc", "Invalid Description Input");
echo "<label for='Description'>Edit Product Description/Summary. Current Description/Summary: " . $product['ProductDescription'] . "</label>";
?>
<input name="Description" type="text" placeholder="Change The Product Summary/Description. Copy/Paste The Current Description If It Only Needs Revisions Here" autocomplete="false"/>
<?php 
printError("brand", "Invalid Brand Input");
echo "<label for='Brand'>Edit Product Manufacturer/Producer. Current Product Name: " . $product['Brand'] . "</label>";
?>
<input name="Brand" type="text" placeholder="Change the Brand Name of the Producer of This Product Here" autocomplete="true"/>
<?php 
printError("price", "Invalid Price Input (Not Money Format)");
printError("freeprice", "Set Price Is Way Too Low To Profit From. Check It Again");
printError('profits', 'Check the numbers of price and cost again. Cost should not be more than our selling price.');
echo "<label for='Price'>Edit Product Price. Current Price of Product: " . $product['Price'] . "</label>";
?>
<input name="Price" type="number" placeholder="Change Product Price Here" autocomplete="true" step="0.01"/>
<?php 
printError("quantity", "Quantity Value Invalid (Either Negative or Non Number)");
echo "<label for='Quantity'>Edit Number of This Product In Stock At Warehouse. Current Recorded Number of Products in Stock: " . $product['Quantity'] . "</label>";
?>
<input name="Quantity" type="number" placeholder="Update Changes To The Stock of This Product We Got Here" autocomplete="false" step="1"/>
<?php 
printError("upload", "File Upload Failed");
printError("file", "Invalid File(s) found in the Set Provided. Check To Make Sure All Files Are Image Files");
printError('limit', 'More Than 4 Files Uploaded. Server Image Upload Can Only Handle 4 at a Time.');
?>
<label for='Images[]'>Add Additional Images Of The Product. If You Need to Remove any Images From The Product View or Want to see the Current Images, Go To <a href='https://imgbb.com/'><img src='Images/imgbb.png' style='width:5%;height:4%;' title='ImgBB' alt='ImgBB'/></a> To Change It (ask admin for login info). Remember That Only 4 Images Can Uploaded at a Time.</label>
<input name="Images[]" type="file" autocomplete="false" multiple accept="image/*"/>
<?php 
printError("wrongselect1", "Option Selected Doesn't Match The Dropdown");
?>
<label for="Category">Change The Type OF Electronic The Product Is Related To Here. Current Listed Electronic Value is <?php echo $product['Category'];?></label>
<select name="Category">
<option value="None">Don't Change</option>
<option value="Desktop">Desktop Computer</option>
<option value="PC">Portable Computer</option>
<option value="Tablet">Tablet Computer</option>
<option value="Celular">Celular Phone</option>
<option value="Phone">Landline Phone</option>
<option value="Security">Security System</option>
</select>
<?php 
printError("wrongselect2", "Option Selected Doesn't Match The Dropdown");
?>
<label for="ProductType">Change The Type Of Product It Is Listed As Here. Current Listed Product Type is <?php echo $product['ProductType']?></label>
<select name="ProductType">
<option value="None">Don't Change</option>
<option value="Electronic">Whole Electronic (PC, Phone, Tablet, Etc)</option>
<option value="Hardware">Hardware Piece For Electronic (CPU, Monitor, Keyboard, Printer, Etc)</option>
<option value="Software">Software For Electronic (OS, Antivirus, Program, etc)</option>
<option value="Accessory">Accessories (Cases, Chargers, USB Drives/SD Cards/Card Readers, Etc)</option>
<option value="Misc">Anything else that Doesn't Fit into the Above Categories</option>
</select>
<?php 
printError("cost", "Invalid Cost Input");
printError("freecost", "The Cost Sounds Too Much of a Miracle To Be True. Check Your Source Again.");
printError('profits', 'Check the numbers of price and cost again. Cost should not be more than our selling price.');
echo "<label for='Cost'>Edit Product Cost To Our Company To Resupply. Current Listed Product Cost To Us Is: " . $product['Cost'] . "</p>";
?>
<input name="Cost" type="number" placeholder="Change Product Cost From Supplier Here" autocomplete="true" step="0.01"/>
<?php 
printError("included", "Quantity Value Invalid (Either Negative, Zero, or Non Number)");
echo "<label for='InPackage'>Edit Product Cost To Our Company To Resupply. Current Listed Product Cost To Us Is: " . $product['InPackage'] . "</p>";
?>
<input name="InPackage" type="number" placeholder="Change The Amount of Units Sold in the Product Package Here" autocomplete="false" step="1"/>
<input type="submit" align=center name="ProductEdit" value="Edit Product Info Now"/>
</form>
</main>
<script>
formSetup();
</script>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>