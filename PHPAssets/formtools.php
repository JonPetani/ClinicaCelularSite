<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Helpful Form Related Functions
*/
//Print a Error Message To Be Put Next To A Input Tag, Requires The ErrorCode Making The GET parameter and the Error Description
//Uses Bootstrap to Define Div Color
function printError(string $errorcode, string $errordesc) {
	if(isset($_GET['error'])) {
		if(strcmp($_GET['error'], $errorcode) == 0) {
			echo "<div class='bg-danger'>";
			printf("<p>%s</p>", $errordesc);
			echo "</div>";
		}
	}
}
//Like printError, but Prints Either Success or Other Related Information
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