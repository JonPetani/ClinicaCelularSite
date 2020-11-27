<?php
function validateApikeyAccess() {
	if(!file_exists("ImportantStuff")) {
		mkdir("ImportantStuff");
		$txt_fp = fopen("ImportantStuff/apikeystack.txt", "w");
		fwrite($txt_fp ,"694ca117ee09307e2c515430556b1a34");
		fclose($txt_fp);
		$txt_fp = fopen("ImportantStuff/apikeyelastic.txt", "w");
		fwrite($txt_fp ,"B0027DE42421044F716EBE2EEB2FE41A937D10F1A462E843C9FAAA99B261BEA654354B8B5CEE02BC87F1245D6A91444B");
		fclose($txt_fp); 
	}
	if(!file_exists("ImportantStuff/apikeystack.txt")) {
		$txt_fp = fopen("ImportantStuff/apikeystack.txt", "w");
		fwrite($txt_fp ,"694ca117ee09307e2c515430556b1a34");
		fclose($txt_fp);
	}
	if(!file_exists("ImportantStuff/apikeyelastic.txt")) {
		$txt_fp = fopen("ImportantStuff/apikeyelastic.txt", "w");
		fwrite($txt_fp ,"B0027DE42421044F716EBE2EEB2FE41A937D10F1A462E843C9FAAA99B261BEA654354B8B5CEE02BC87F1245D6A91444B");
		fclose($txt_fp); 
	}
}
function directoryCodeGenerator(int $size_min, int $size_max) {
	$str = "";
	for($i = 0; $i < random_int($size_min, $size_max); $i++)	
		$str = $str . chr(random_int(48, 122));
	return $str;
}
function getEmployeeCodeAccess(object $con) {
	$sql = $con -> prepare("SELECT * FROM sitecodes WHERE CodeName = :code");
	$codename = "EmployeeCode";
	$sql -> bindParam(":code", $codename);
	$sql -> execute();
	$code = directoryCodeGenerator(20, 30);
	$time = date('Y-m-d');
	if($sql -> rowCount() < 1) {
		$sql = $con -> prepare("INSERT INTO sitecodes(CodeName, CodeValue, LastUpdated) VALUES (:name, :ecode, :time)");
		$sql -> bindParam(":name", $codename);
		$sql -> bindParam(":ecode", $code);
		$sql -> bindParam("time", $time);
		$sql -> execute();
		$sql = $con -> prepare("SELECT * FROM sitecodes WHERE CodeName = :code");
		$sql -> bindParam(':code', $codename);
		$sql -> execute();
		$code = $sql -> fetch(PDO::FETCH_ASSOC);
		return $code['CodeValue'];
	}
	else {
		$code = $sql -> fetch(PDO::FETCH_ASSOC);
		if(empty($code['CodeValue'])) {
			$sql = $con -> prepare("UPDATE sitecodes SET CodeValue = :ecode, LastUpdated = :time WHERE CodeName = :code");
			$sql -> bindParam(":ecode", $code);
			$sql -> bindParam(":time", $time);
			$sql -> bindParam(":code", $codename);
			$sql -> execute();
			$sql = $con -> prepare("SELECT * FROM sitecodes WHERE CodeName = :code");
			$sql -> execute();
			$code = $sql -> fetch(PDO::FETCH_ASSOC);
		}
		return $code['CodeValue'];
	}		
}
//If you somehow deleted all the workers and admins this func will repopulate the employee system effectively
function adminPopulate(object $con) {
	$sql = $con -> prepare("SELECT * FROM employee WHERE AdminPassword IS NOT NULL");
	$sql -> execute();
	if($sql -> rowCount() < 1) {
		$pword = directoryCodeGenerator(25, 30);
		$adminword = directoryCodeGenerator(35, 40);
		$fname = "Simon";
		$lname = "Jacinto";
		$email = "dereisengott@gmail.com";
		$dinero = 0.0;
		$role = "System Admin";
		$secure = true;
		$keep = false;
		$insert = $con -> prepare("INSERT INTO employee(FirstName, LastName, EmailAddress, Role, Salary, Password, KeepLoggedIn, IsSecure, AdminPassword) VALUES (:fname, :lname, :email, :role, :sal, :pword, :log, :secure, :admin)");
		$insert -> bindParam(':fname', $fname);
		$insert -> bindParam(':lname', $lname);
		$insert -> bindParam(':email', $email);
		$insert -> bindParam(':role', $role);
		$insert -> bindParam(':sal', $dinero);
		$insert -> bindParam(':pword', $pword);
		$insert -> bindParam(':log', $keep);
		$insert -> bindParam(':secure', $secure);
		$insert -> bindParam(':admin', $adminword);
		$insert -> execute();
	}
}
?>