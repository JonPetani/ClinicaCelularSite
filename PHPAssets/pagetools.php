<?php
function errorPageDisplay(string $reason) {
	echo "<div id='Error'>";
	printf("<p>%s</p>", $reason);
	echo "</div>";
}
function changeButton(string $returncode, string $button, string $buttontxt) {
	if(isset($_GET['return'])) {
		if(strcmp($_GET['return'], $returncode) == 0) {
			echo "<script>";
			printf("$('%s').text('%s')", $button, $buttontxt);
			echo "</script>";
		}
	}
}
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
	$arr_key = array_search($field, $_SESSION, false);
	if($arr_key == 'Password') {
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
	$method = "aes-256-gcm";
	return openssl_decrypt($field, $method, $_SESSION['CipherKey'], OPENSSL_RAW_DATA, $_SESSION['IVLength'], $_SESSION['tags'][$arr_key]);
}
function randomCodeGenerator(int $size_min, int $size_max) {
	$str = "";
	for($i = 0; $i < random_int($size_min, $size_max); $i++)	
		$str = $str . chr(random_int(48, 122));
	return $str;
}
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
	$method = "aes-256-gcm";
	if(!isset($_SESSION['CipherKey']) or !isset($_SESSION['IVLength'])) {
		$_SESSION['CipherKey'] = openssl_digest(randomCodeGenerator(12, 16), 'sha256', true);
		$_SESSION['IVLength'] = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
	}
	if(!isset($_SESSION['tags']))
		$_SESSION['tags'] = array();
	foreach($user_data as $account_fields => $value) {
		if(is_string($value)) {
			if(preg_match("^.*Password.*$^", $account_fields) != 0)
				$_SESSION[$account_fields] = password_hash($value, PASSWORD_ARGON2ID);
			else {
				$tag_set['tags'][$account_fields] = "";
				$_SESSION[$account_fields] = openssl_encrypt($value, $method, $_SESSION['CipherKey'], OPENSSL_RAW_DATA, $_SESSION['IVLength'], $_SESSION['tags'][$account_fields], '', 16);
			}
		}
		else
			$SESSION[$account_fields] = $value;
	}
	return true;
}
function setAccountTabs() {
	if(isset($_SESSION['logged']) and isset($_SESSION['type'])) {
		if(strcmp($_SESSION['logged'], 'loggedin') == 0) {
			switch($_SESSION['type']) {
				case 'customer':
				echo"<script>";
				echo"$('#register').remove();";
				echo"$('#login').remove();";
				echo"$('nav').append('<a href=\'loggedin.php\'>My Account</a>');";
				echo"$('nav').append('<a href=\'logout.php\'>Log Out</a>');";
				echo"$('nav').find('a').css('padding', '10px 35px 10px 35px');";
				echo"</script>";
				break;
				
				case 'employee':
				echo"<script>";
				$dimensions = "$('nav').find('a').css('padding', '10px 10px 10px 10px');";
				echo"$('nav').empty();";
				echo"$('nav').append('<a href=\'employeehome.php\'>Customer Pages</a>');";
				echo"$('nav').append('<a href=\'employeehome.php\'>Report Issue</a>');";
				echo"$('nav').append('<a href=\'employeehome.php\'>View Orders</a>');";
				echo"$('nav').append('<a href=\'employeehome.php\'>Assist Customers</a>');";
				echo"$('nav').append('<a href=\'employeehome.php\'>Manage Store Inventory</a>');";
				if(isset($_SESSION['admin'])) {
					if($_SESSION['admin'] == true) {
						echo"$('nav').append('<a href=\'employeehome.php\'>Admin Resources</a>');";
					    $dimensions = "$('nav').find('a').css({'padding': '10px 9px 10px 9px', 'font-size': '137%'});";
					}
					else
						$dimensions = "$('nav').find('a').css('padding', '10px 10px 10px 10px');";
				}
				else
					$dimensions = "$('nav').find('a').css('padding', '10px 10px 10px 10px');";
				echo"$('nav').append('<a href=\'employeehome.php\'>My Account</a>');";
				echo"$('nav').append('<a href=\'logout.php\'>Log Out</a>');";
				echo $dimensions;
				echo"</script>";
				break;
			}
		}
	}
}
?>