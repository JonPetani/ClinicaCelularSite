<!--
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: New Product Upload Form To Add To Site Inventory
-->
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="CSS/main.css" rel="stylesheet"/>
<script src="JS/formsetup.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@100&display=swap');
</style>
<title>Upload Product To System</title>
<link href="Images/TabImg.png" rel="icon"/>
</head>
<body>
<?php
require "PHPAssets/connect.php";
require "PHPAssets/formtools.php";
require "PHPAssets/pagetools.php";
require "PHPAssets/accounttools.php";
//Checks If Uploader Is Employee
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
?>
<div class="container">
<?php
setAccountTabs($con);
?>
<main align=center>
<br clear=both>
<h1>Add a New Product to the Site</h1>
<!--Product Upload Form-->
<form action="inventoryupload.php" method="POST" enctype="multipart/form-data">
<?php
printError("loading", "Submission of Information Failed. Try Again.");
printError("duplicate", "Product Already Exists, Check <ah href='productinventory.php'>this page</a> to Find It");
printError("bug", "A bug occured during a site operation. Try Submitting Again");
printError("name", "Invalid Product Name Input");
printInfo("uploaded", "Product Uploaded Successfully! If You Don't Need To Insert Anything Else, See What You Uploaded <a href='productinventory.php'>Here</a>");
?>
<input name="Name" type="text" placeholder="Full Name of the Product As Seen From The Source" required autocomplete="false"/>
<?php 
printError("desc", "Invalid Description Input");
?>
<input name="Description" type="text" placeholder="Paragraph Summary of the Product Listed" required autocomplete="false"/>
<?php 
printError("brand", "Invalid Brand Input");
?>
<input name="Brand" type="text" placeholder="The Manufacturer of This Product" required autocomplete="true"/>
<?php 
printError("price", "Invalid Price Input (Not Money Format)");
printError("freeprice", "Set Price Is Way Too Low To Profit From. Check It Again");
printError('profits', 'Check the numbers of price and cost again. Cost should not be more than our selling price.');
?>
<!--Only Decimal Up To Hundredths Place Is Allowed-->
<input name="Price" type="number" placeholder="How Much We Sell This Product For" required autocomplete="true" step="0.01"/>
<?php 
printError("quantity", "Quantity Value Invalid (Either Negative or Non Number)");
?>
<!--Only Int Allowed-->
<input name="Quantity" type="number" placeholder="How Much Of The Product We Got In Stock Now" required autocomplete="false" step="1"/>
<?php 
printError("upload", "File Upload Failed");
printError("file", "Invalid File(s) found in the Set Provided. Check To Make Sure All Files Are Image Files");
printError('limit', 'More Than 4 Files Uploaded. Server Image Upload Can Only Handle 4 at a Time.');
?>
<!--Upload Up To 4 Images as Array. Array Size Is Checked Server Side-->
<label for='Images[]'>Upload Images Of The Product. Maximum of 4 Allowed To Start For Quality Control and Server Limits.</label>
<input name="Images[]" type="file" required autocomplete="false" multiple accept="image/*"/>
<?php 
printError("wrongselect1", "Option Selected Doesn't Match The Dropdown");
?>
<label for="Category">What Category of Electronic Is It Related To</label>
<select name="Category" required>
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
<label for="ProductType">What Type of Product Is It</label>
<select name="ProductType" required>
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
?>
<!--Only Decimal Up To Hundredths Place Is Allowed-->
<input name="Cost" type="number" placeholder="How Do The Distributers Charge Us For The Product Per Unit" required autocomplete="true" step="0.01"/>
<?php 
printError("included", "Quantity Value Invalid (Either Negative, Zero, or Non Number)");
?>
<input name="InPackage" type="number" placeholder="To Ensure Product Quality, How Much Items Are Included Per Package Sold To Customers" required autocomplete="false" step="1"/>
<input type="submit" align=center name="ProductInsert" value="Insert Product Now"/>
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