<?php
function printReturn(string $returncode, string $returntxt) {
	if(isset($_GET['return'])) {
		if(strcmp($_GET['return'], $returncode) == 0) {
			printf("<p>%s</p>", $returntxt);
		}
	}
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
	if(!isset($currentMethod) and !isset($iv)) {
		$cipher = $con -> prepare("SELECT * FROM customer WHERE CipherKey = :key");
		$cipher -> bindParam(':key', $_SESSION['key']);
		$cipher -> execute();
		if($cipher -> rowCount() <= 0) {
			session_destroy();
			header("Location: login.php?error=bug");
			die;
		}
		$cipherInfo = $cipher -> fetch(PDO::FETCH_ASSOC);
		if(empty($cipherInfo['SecureMethod']) or empty($cipherInfo['IVLength'])) {
			session_destroy();
			header("Location: login.php?error=bug");
			die;
		}
		return openssl_decrypt($field, $cipherInfo['SecureMethod'], $_SESSION['key'], 0, $cipherInfo['IVLength']);
	}
	else {
		return openssl_decrypt($field, $currentMethod, $_SESSION['key'], 0, $cipherInfo['IVLength']);
	}
}
?>