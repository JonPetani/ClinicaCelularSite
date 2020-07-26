<?php
function sendText(string $message, string $recipient) {
	$fp = fopen("../ImportantStuff/apikey.txt");
	$apikey = fread($fp);
	fclose($fp);
}
?>