<?php
function printError(string $errorcode, string $errordesc) {
	if(isset($_GET['error'])) {
		if(strcmp($_GET['error'], $errorcode) == 0) {
			echo "<div class='bg-danger'>";
			printf("<p>%s</p>", $errordesc);
			echo "</div>";
		}
	}
}
function printInfo(string $infocode, string $info) {
	if(isset($_GET['info'])) {
		if(strcmp($_GET['info'], $infocode) == 0) {
			echo "<div class='bg-success'>";
			printf("<p>%s</p>", $info);
			echo "</div>";
		}
	}
}
?>