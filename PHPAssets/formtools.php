<?php
function printError(string $errorcode, string $errordesc) {
	if(isset($_GET['error'])) {
		if(strcmp($_GET['error'], $errorcode) == 0) {
			printf("<p>%s</p>", $errordesc);
		}
	}
}
?>