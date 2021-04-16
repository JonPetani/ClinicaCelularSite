<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Functions For Communication From Site To Users
*/
require "PHPAssets/dir.php";
//To Send SMS Text To User
function sendText(string $message, string $mobile_num, object $con) {
	//make sure Apikeys can be accessed
	validateApikeyAccess();
	//Check message and number for errors
	if(empty($message) or empty($mobile_num) or preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^' ,$mobile_num) == 0)
		return false;
	//get IPStack Apikey
	$fp = fopen("ImportantStuff/apikeystack.txt", 'r');
	$apikey = fgets($fp);
	fclose($fp);
	//Get User IP To Find Country of Service
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$alt_ip = $_SERVER['REMOTE_ADDR'];
	}
	else
		$ip_address = $_SERVER['REMOTE_ADDR'];
	//Use IPStack API To Match IP To Country
	$request = curl_init("http://api.ipstack.com/check?access_key=" . $apikey . '');
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	$get_location = curl_exec($request);
	curl_close($request);
	$country = json_decode($get_location);
	//Map Country To Country Code
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
	//Append Country Code to Mobile Number To Send Text
	$number = $country_code . $mobile_num;
	$text_fields = array(
		'apikey' => $apikey,
		'body' => $message,
		'to' => $number
	);
	//get Elastic Email Apikey
	$fp = fopen("ImportantStuff/apikeyelastic.txt", 'r');
	$apikey = fgets($fp);
	fclose($fp);
	//Send Curl Request to Send SMS With Needed Parameters
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
//Send HTML Email To User
function sendEmail(string $sender, string $htmlbody, string $recipient, string $subject) {
	//check Inputs for Errors
	if(preg_match("^.*@.*$^", $sender) == 0 or preg_match("^.*@.*$^", $recipient) == 0 or empty($htmlbody) or empty($subject))
		return false;
	validateApikeyAccess();
	//get Elastic Email Apikey
	$fp = fopen("ImportantStuff/apikeyelastic.txt", "r");
	$apikey = fgets($fp);
	fclose($fp);
	//Send Email Curl Request With Needed Parameters and Settings
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
//Verify Email Address Belongs To Account Before Sending To Avoid Exploitation of Email Send
function verifyAddress(string $address, object $con) {
	$sql = $con -> prepare("SELECT * FROM customer WHERE EmailAddress = :email");
	$sql -> bindParam(":email", $address);
	$sql -> execute();
	if($sql -> rowCount() < 0)
		return false;
	return true;
}
?>