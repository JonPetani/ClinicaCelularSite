<?php
/* 
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Utility Functions used in many PHP Files on the Site
*/

//Page Error Message
//Print Error Message With Text and Stop Page Contents To Showcase Error and Restrict Viewing
function errorPageDisplay(string $reason) {
	echo "<div id='Error'>";
	printf("<p>%s</p>", $reason);
	echo "</div>";
	die;
}

//Edit Button Text and Format
function changeButton(string $returncode, string $button, string $buttontxt) {
	if(isset($_GET['return'])) {
		if(strcmp($_GET['return'], $returncode) == 0) {
			echo "<script>";
			printf("$('%s').text('%s')", $button, $buttontxt);
			echo "</script>";
		}
	}
}

//Decrypt Encrypted Session Data (Called For Each Reveal Of Encrypted Data)
function decryptDisplay(string $field, object $con) {
	if(!isset($_SESSION['CipherKey']) or !isset($_SESSION['IVLength']) or !isset($_SESSION['tags'])) {
		session_destroy();
		header("Location: login.php?error=deployment");
		die;
	}
	if(!isset($_SESSION['CodeValue'])) {
		if(!isset($_SESSION['logged'])) {
			session_destroy();
			header("Location: login.php?error=bug");
			die;
		}
		if($_SESSION['logged'] != 'loggedin') {
			session_destroy();
			header("Location: login.php?error=nologin");
			die;
		}
	}
	//Search For Needed Session Variable Using Function Parameter (Especially Needed For Password Use Case)
	$arr_key = array_search($field, $_SESSION, false);
	if(strcmp($arr_key, "Password") == 0) {
		$account = decryptDisplay($_SESSION['EmailAddress'], $con);
		if(!isset($_SESSION['type'])) {
			session_destroy();
			header("Location: login.php?error=bug");
			die;
		}
		switch($_SESSION['type']) {
			case 'customer':
			$ptest = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :acc");
			break;
			
			case 'employee':
			$ptest = $con -> prepare("SELECT * FROM employee WHERE EmailAddress = :acc");
			break;
			
			default:
			session_destroy();
			header("Location: login.php?error=bug");
			die;
		}
		$ptest -> bindParam(':acc', $account);
		$ptest -> execute();
		$pword = $ptest -> fetch(PDO::FETCH_ASSOC);
		//Only Reveal Password Value From DB if it Matches with the Password Hash From Encrypt
		$is_password = password_verify($pword['Password'], $_SESSION['Password']);
		if($is_password == false) {
			session_destroy();
			header("Location: login.php?error=nologin");
			die;
		}
		else {
			return $pword['Password'];
		}	
	}
	//Returns Decrypted Value (If You Didn't Encrypt Properly The Information Is Safe From Viewing By Undesired Eyes)
	$method = "aes-256-gcm";
	return openssl_decrypt($field, $method, $_SESSION['CipherKey'], OPENSSL_RAW_DATA, $_SESSION['IVLength'], $_SESSION['tags'][$arr_key]);
}

//Useful When A Random String Is Needed (Used Mainly For Encryption And Selecting Verification Code For Email + SMS)
function randomCodeGenerator(int $size_min, int $size_max) {
	$str = "";
	for($i = 0; $i < random_int($size_min, $size_max); $i++)	
		$str = $str . chr(random_int(48, 122));
	return $str;
}

//Encrypt A Entire Set of Session Data
//Requires Assosiative Array To Work
function encryptSet(array $user_data, object $con) {
	if(!isset($_POST['Code'])) {
		if(!isset($_SESSION['logged'])) {
			session_destroy();
			header("Location: login.php?error=bug");
			die;
		}
		if($_SESSION['logged'] != 'loggedin') {
			session_destroy();
			header("Location: login.php?error=nologin");
			die;
		}
	}
	//Used Cipher Method
	$method = "aes-256-gcm";
	//IV
	if(!isset($_SESSION['CipherKey']) or !isset($_SESSION['IVLength'])) {
		$_SESSION['CipherKey'] = openssl_digest(randomCodeGenerator(12, 16), 'sha256', true);
		$_SESSION['IVLength'] = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
	}
	//Array of Tags For Each Encryption
	if(!isset($_SESSION['tags']))
		$_SESSION['tags'] = array();
	foreach($user_data as $account_fields => $value) {
		if(is_string($value)) {
			//For Password Session Vars
			if(preg_match("^.*Password.*$^", $account_fields) != 0)
				$_SESSION[$account_fields] = password_hash($value, PASSWORD_DEFAULT);
			else {
				//For Other Vars Except Boolean
				$tag_set['tags'][$account_fields] = "";
				$_SESSION[$account_fields] = openssl_encrypt($value, $method, $_SESSION['CipherKey'], OPENSSL_RAW_DATA, $_SESSION['IVLength'], $_SESSION['tags'][$account_fields], '', 16);
			}
		}
		else
			$SESSION[$account_fields] = $value;
	}
	return true;
}

//Set Header Based On Account Type (Customer, Default User, Employee, and Employee with Admin Priveleges)
//Includes Header Logo, Nav Bar, and SearchBar (Footer Is Seen At Bottom of Each PHP Page File)
function setAccountTabs(object $con) {
	if(isset($_SESSION['logged']) and isset($_SESSION['type'])) {
		if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
			switch($_SESSION['type']) {
				case 'customer':
				echo "<div class='row'>";
				echo '<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png"  style="width:65%;height50%;background-color:MediumPurple;" title="Clinica Celular" alt="Clinica Celular"/></a></div>';
				echo '<div class="col-sm-4"><form action="store.php?action=search"><input class="search" id="headerbar" onfocus="searchBarHelpText(this)" onfocusout="searchBarDefaultText(this)" type="text" name="SearchQuery" placeholder="Looking For Something? Find it Here" required autocomplete="false"/></form></div>';
				echo '<div class="col-sm-4"><ul class="nav nav-tabs justify-content-center navbar-dark bg-dark"><li class="nav-item"><a class="nav-link" href="shoppingcart.php">&#128722;</a></li></ul></div>';
				echo "</div>";
				echo '<ul class="nav nav-tabs justify-content-center navbar-dark bg-dark">';
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="repairshop.php">Tech Services</a>';
				echo '</li>';
				echo '<li class="nav-item dropdown">';
				echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Online Tech Shop</a>';
				echo '<div class="dropdown-menu" style="overflow-y:auto;">';
				echo '<h5 class="dropdown-header">Shop All our Products</h5>';
				echo "<a class='dropdown-item' href='store.php'>Our Full Inventory</a>";
				echo '<div class="dropdown-divider"></div>';
				echo '<h5 class="dropdown-header">Shop by Brand</h5>';
				$brand_names = $con -> prepare('SELECT DISTINCT Brand FROM product');
				$brand_names -> execute();
				$brand_links = $brand_names -> fetchAll(PDO::FETCH_ASSOC);
				for($i = 0; $i < sizeof($brand_links); $i++) {
					printf("<a class='dropdown-item' href='store.php?Brand=%s'>%s</a>", $brand_links[$i]['Brand'], $brand_links[$i]['Brand']);
				}
				echo '<div class="dropdown-divider"></div>';
				echo '<h5 class="dropdown-header">Shop by Electronic</h5>';
				echo "<a class='dropdown-item' href='store.php?Cat=PC'>PCs/Laptops</a>";
				echo "<a class='dropdown-item' href='store.php?Cat=Tablet'>Tablets</a>";
				echo "<a class='dropdown-item' href='store.php?Cat=Desktop'>Desktop Computers</a>";
				echo "<a class='dropdown-item' href='store.php?Cat=Phone'>Landline Telephones</a>";
				echo "<a class='dropdown-item' href='store.php?Cat=Celular'>Cell Phones</a>";
				echo "<a class='dropdown-item' href='store.php?Cat=Security'>Security Systems</a>";
				echo '<div class="dropdown-divider"></div>';
				echo '<h5 class="dropdown-header">Shop by Product Type</h5>';
				echo "<a class='dropdown-item' href='store.php?Type=Electronic'>Electronic Devices</a>";
				echo "<a class='dropdown-item' href='store.php?Type=Hardware'>Hardware Pieces</a>";
				echo "<a class='dropdown-item' href='store.php?Type=Software'>Electronic Software</a>";
				echo "<a class='dropdown-item' href='store.php?Type=Accessory'>Accessories for your Devices</a>";
				echo "<a class='dropdown-item' href='store.php?Type=Misc'>Other Products</a>";
				echo "</div>";
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="about.php">About Us</a>';
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="contact.php">Contact Us</a>';
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="loggedin.php" >My Account</a>';
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="logout.php">Log Out</a>';
				echo '</li>';
				echo '</ul>';
				break;
				
				case 'employee':
				echo "<div class='row'>";
				echo '<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png" style="width:65%;height50%;background-color:MediumPurple;" title="Clinica Celular" alt="Clinica Celular"/></a></div>';
				echo '<div class="col-sm-4"><form action="store.php?action=search"><input class="search" type="text" name="SearchQuery" placeholder="Looking For Something? Find it Here" required autocomplete="false"/></form></div>';
				echo "</div>";
				echo '<ul class="nav nav-tabs justify-content-center navbar-dark bg-dark">';
				echo '<li class="nav-item dropdown">';
				echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Customer Pages</a>';
				echo '<div class="dropdown-menu">';
				echo "<a class='dropdown-item' href='Home.php'>Home Page</a>";
				echo "<a class='dropdown-item' href='repairshop.php'>Repair Services Page</a>";
				echo "<a class='dropdown-item' href='store.php'>Ecommerce Shop Page</a>";
				echo "<a class='dropdown-item' href='about.php'>About Company Page</a>";
				echo "<a class='dropdown-item' href='contact.php'>Customer Contact Company Page</a>";
				echo "<a class='dropdown-item' href='register.php'>Customer Registration Form</a>";
				echo "<a class='dropdown-item' href='login.php'>Customer Login Form</a>";
				echo "</div>";
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="systemreport.php">Report Issue</a>';
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="orders.php">View Customer Orders</a>';
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="contactposts.php" >Customer Questions</a>';
				echo "</li>";
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="productinventory.php">Store Inventory</a>';
				echo '</li>';
				if(isset($_SESSION['admin'])) {
					if($_SESSION['admin'] == true) {
						echo '<li class="nav-item dropdown">';
						echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Admin Tools</a>';
						echo '<div class="dropdown-menu">';
						echo '<a class="dropdown-item" href="adminhub.php">View Detailed Information of Admin Tools</a>';
						echo '<a class="dropdown-item" href="users.php">Manage Users On Site</a>';
						echo '<a class="dropdown-item" href="keys.php">Update Site Keys</a>';
						echo '<a class="dropdown-item" href="lockdown.php">Lockdown/Unlock Site</a>';
						echo "</div>";
						echo "</li>";
					}
				}
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="employeehome.php">My Account</a>';
				echo '</li>';
				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="logout.php">Log Out</a>';
				echo '</li>';
				echo '</ul>';
				break;
			}
		}
		else {
			echo "<div class='row'>";
			echo '<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png" style="width:65%;height50%;background-color:MediumPurple;" title="Clinica Celular" alt="Clinica Celular"/></a></div>';
			echo '<div class="col-sm-4"><form action="store.php?action=search"><input class="search" onfocus="searchBarHelpText(this)" onfocusout="searchBarDefaultText(this)" type="text" name="SearchQuery" placeholder="Looking For Something? Find it Here" required autocomplete="false"/></form></div>';
			echo '<div class="col-sm-4"><ul class="nav nav-tabs justify-content-center navbar-dark bg-dark"><li class="nav-item"><a class="nav-link" href="register.php?addon=hub">To Begin Your Shopping/Service Experience, Sign Up</a></li></ul></div>';			echo "</div>";
			echo '<ul class="nav nav-tabs justify-content-center navbar-dark bg-dark">';
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="repairshop.php">Tech Services</a>';
			echo '</li>';
			echo '<li class="nav-item dropdown">';
			echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Online Tech Shop</a>';
			echo '<div class="dropdown-menu" style="overflow-y:auto;">';
			echo '<h5 class="dropdown-header">Shop All our Products</h5>';
			echo "<a class='dropdown-item' href='store.php'>Our Full Inventory</a>";
			echo '<div class="dropdown-divider"></div>';
			echo '<h5 class="dropdown-header">Shop by Brand</h5>';
			$brand_names = $con -> prepare('SELECT DISTINCT Brand FROM product');
			$brand_names -> execute();
			$brand_links = $brand_names -> fetchAll(PDO::FETCH_ASSOC);
			for($i = 0; $i < sizeof($brand_links); $i++) {
				printf("<a class='dropdown-item' href='store.php?Brand=%s'>%s</a>", $brand_links[$i]['Brand'], $brand_links[$i]['Brand']);
			}
			echo '<div class="dropdown-divider"></div>';
			echo '<h5 class="dropdown-header">Shop by Electronic</h5>';
			echo "<a class='dropdown-item' href='store.php?Cat=PC'>PCs/Laptops</a>";
			echo "<a class='dropdown-item' href='store.php?Cat=Tablet'>Tablets</a>";
			echo "<a class='dropdown-item' href='store.php?Cat=Desktop'>Desktop Computers</a>";
			echo "<a class='dropdown-item' href='store.php?Cat=Phone'>Landline Telephones</a>";
			echo "<a class='dropdown-item' href='store.php?Cat=Celular'>Cell Phones</a>";
			echo "<a class='dropdown-item' href='store.php?Cat=Security'>Security Systems</a>";
			echo '<div class="dropdown-divider"></div>';
			echo '<h5 class="dropdown-header">Shop by Product Type</h5>';
			echo "<a class='dropdown-item' href='store.php?Type=Electronic'>Electronic Devices</a>";
			echo "<a class='dropdown-item' href='store.php?Type=Hardware'>Hardware Pieces</a>";
			echo "<a class='dropdown-item' href='store.php?Type=Software'>Electronic Software</a>";
			echo "<a class='dropdown-item' href='store.php?Type=Accessory'>Accessories for your Devices</a>";
			echo "<a class='dropdown-item' href='store.php?Type=Misc'>Other Products</a>";
			echo "</div>";
			echo "</li>";
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="about.php">About Us</a>';
			echo "</li>";
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="contact.php">Contact Us</a>';
			echo "</li>";
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="register.php" >Register Account</a>';
			echo "</li>";
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="login.php">Log In</a>';
			echo '</li>';
			echo '</ul>';
		}
	}
	else {
		echo "<div class='row'>";
		echo '<div class="col-sm-4"><a href="Home.php"><img src="Images/ClinicaIcon.png" style="width:65%;height50%;background-color:MediumPurple;" title="Clinica Celular" alt="Clinica Celular"/></a></div>';
		echo '<div class="col-sm-4"><form action="store.php?action=search"><input class="search" onfocus="searchBarHelpText(this)" onfocusout="searchBarDefaultText(this)" type="text" name="SearchQuery" placeholder="Looking For Something? Find it Here" required autocomplete="false"/></form></div>';
		echo '<div class="col-sm-4"><ul class="nav nav-tabs justify-content-center navbar-dark bg-dark"><li class="nav-item"><a class="nav-link" href="register.php?addon=hub">To Begin Your Shopping/Service Experience, Sign Up</a></li></ul></div>';
		echo "</div>";
		echo "<br>";
		echo '<ul class="nav nav-tabs justify-content-center navbar-dark bg-dark">';
		echo '<li class="nav-item">';
		echo '<a class="nav-link" href="repairshop.php">Tech Services</a>';
		echo '</li>';
		echo '<li class="nav-item dropdown">';
		echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="">Online Tech Shop</a>';
		echo '<div class="dropdown-menu" style="overflow-y:auto;">';
		echo '<h5 class="dropdown-header">Shop All our Products</h5>';
		echo "<a class='dropdown-item' href='store.php'>Our Full Inventory</a>";
		echo '<div class="dropdown-divider"></div>';
		echo '<h5 class="dropdown-header">Shop by Brand</h5>';
		$brand_names = $con -> prepare('SELECT DISTINCT Brand FROM product');
		$brand_names -> execute();
		$brand_links = $brand_names -> fetchAll(PDO::FETCH_ASSOC);
		for($i = 0; $i < sizeof($brand_links); $i++) {
			printf("<a class='dropdown-item' href='store.php?Brand=%s'>%s</a>", $brand_links[$i]['Brand'], $brand_links[$i]['Brand']);
		}
		echo '<div class="dropdown-divider"></div>';
		echo '<h5 class="dropdown-header">Shop by Electronic</h5>';
		echo "<a class='dropdown-item' href='store.php?Cat=PC'>PCs/Laptops</a>";
		echo "<a class='dropdown-item' href='store.php?Cat=Tablet'>Tablets</a>";
		echo "<a class='dropdown-item' href='store.php?Cat=Desktop'>Desktop Computers</a>";
		echo "<a class='dropdown-item' href='store.php?Cat=Phone'>Landline Telephones</a>";
		echo "<a class='dropdown-item' href='store.php?Cat=Celular'>Cell Phones</a>";
		echo "<a class='dropdown-item' href='store.php?Cat=Security'>Security Systems</a>";
		echo '<div class="dropdown-divider"></div>';
		echo '<h5 class="dropdown-header">Shop by Product Type</h5>';
		echo "<a class='dropdown-item' href='store.php?Type=Electronic'>Electronic Devices</a>";
		echo "<a class='dropdown-item' href='store.php?Type=Hardware'>Hardware Pieces</a>";
		echo "<a class='dropdown-item' href='store.php?Type=Software'>Electronic Software</a>";
		echo "<a class='dropdown-item' href='store.php?Type=Accessory'>Accessories for your Devices</a>";
		echo "<a class='dropdown-item' href='store.php?Type=Misc'>Other Products</a>";
		echo "</div>";
		echo "</li>";
		echo '<li class="nav-item">';
		echo '<a class="nav-link" href="about.php">About Us</a>';
		echo "</li>";
		echo '<li class="nav-item">';
		echo '<a class="nav-link" href="contact.php">Contact Us</a>';
		echo "</li>";
		echo '<li class="nav-item">';
		echo '<a class="nav-link" href="register.php" >Register Account</a>';
		echo "</li>";
		echo '<li class="nav-item">';
		echo '<a class="nav-link" href="login.php">Log In</a>';
		echo '</li>';
		echo '</ul>';
	}
}
/*function setRollEffectsProductIcon(string $rollOver, string $rollOut) {
}*/
?>