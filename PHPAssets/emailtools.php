<?php
function sendText(string $message, string $mobile_num) {
	if(empty($message) or empty($mobile_num) or preg_match('^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}$^' ,$mobile_num) == 0)
		return false;
	$fp = fopen("../ImportantStuff/apikey.txt");
	$apikey = fread($fp);
	fclose($fp);
	$request = curl_init();
	$url = "https://api.elasticemail.com/v2/sms/send";
	curl_setopt($request, CURLOPT_URL, $url);
	if(!empty($_SERVER['HTTP_CLIENT_IP']))
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$alt_ip = $_SERVER['REMOTE_ADDR'];
	else
		$ip_address = $_SERVER['REMOTE_ADDR'];
	$country = geoip_country_code_by_name($ip_address);
	switch($country) {
		case "MX":
			$country_code = "+52";
			break;
		case "US":
		case "CA":
			$country_code = "+1";
			break;
		default: 
			return false;
	}
	$number = $country_code . $mobile_num;
	$text_fields = array(
		'apikey' => $apikey,
		'body' => $message,
		'to' => $number
	);
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
?>