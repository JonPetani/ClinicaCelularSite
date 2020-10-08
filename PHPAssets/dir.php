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
?>