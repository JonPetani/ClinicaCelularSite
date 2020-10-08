<?php
require "PHPAssets/dir.php";
function sendText(string $message, string $mobile_num, object $con) {
	validateApikeyAccess();
	if(empty($message) or empty($mobile_num) or preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^' ,$mobile_num) == 0)
		return false;
	$fp = fopen("ImportantStuff/apikeystack.txt", 'r');
	$apikey = fgets($fp);
	fclose($fp);
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$alt_ip = $_SERVER['REMOTE_ADDR'];
	}
	else
		$ip_address = $_SERVER['REMOTE_ADDR'];
	$request = curl_init("http://api.ipstack.com/check?access_key=" . $apikey . '');
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	$get_location = curl_exec($request);
	curl_close($request);
	$country = json_decode($get_location);
	switch($country->country_code) {
		case "MX":
			$country_code = "+52";
			break;
		case "US":
		case "CA":
			$country_code = "+1";
			break;
		default: 
			return "No IP Found";
	}
	$number = $country_code . $mobile_num;
	$text_fields = array(
		'apikey' => $apikey,
		'body' => $message,
		'to' => $number
	);
	$fp = fopen("ImportantStuff/apikeyelastic.txt", 'r');
	$apikey = fgets($fp);
	fclose($fp);
	$request = curl_init();
	$url = "https://api.elasticemail.com/v2/sms/send";
	curl_setopt($request, CURLOPT_URL, $url);
	curl_setopt($request, CURLOPT_HEADER, false);
	curl_setopt($request, CURLOPT_POST, true);
	curl_setopt($request, CURLOPT_POSTFIELDS, $text_fields);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
	$timeout = 45;
	curl_setopt($request, CURLOPT_TIMEOUT, $timeout);
	$send_text = curl_exec($request);
	curl_close($request);
	return true;
}
function sendEmail(string $sender, string $htmlbody, string $recipient, string $subject) {
	if(preg_match("^.*@.*$^", $sender) == 0 or preg_match("^.*@.*$^", $recipient) == 0 or empty($htmlbody) or empty($subject))
		return false;
	validateApikeyAccess();
	$fp = fopen("ImportantStuff/apikeyelastic.txt", "r");
	$apikey = fgets($fp);
	fclose($fp);
	$request = curl_init();
	$url = "https://api.elasticemail.com/v2/email/send";
	$email_fields = array(
		'apikey' => $apikey,
		'bodyHtml' => $htmlbody,
		'char-set' => 'utf-8',
		'from' => $sender,
		'to' => $recipient,
		'sender' => $sender,
		'subject' => $subject
		//'postBack' => "message to" . $sender . "was successful"
	);
	curl_setopt($request, CURLOPT_URL, $url);
	curl_setopt($request, CURLOPT_HEADER, false);
	curl_setopt($request, CURLOPT_POST, true);
	curl_setopt($request, CURLOPT_POSTFIELDS, $email_fields);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
	$timeout = 45;
	curl_setopt($request, CURLOPT_TIMEOUT, $timeout);
	$send_email = curl_exec($request);
	curl_close($request);
	return true;
}
function verifyAddress(string $address, object $con) {
	$sql = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :email");
	$sql -> bindParam(":email", $address);
	$sql -> execute();
	if($sql -> rowCount() < 0)
		return false;
	return true;
}
?>