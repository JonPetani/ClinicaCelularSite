<?php
/*
Programmer: Jonathan Petani
Date: April 2020 - April 2021
Purpose: Tools to Help Submit Special Data From Forms Such as Images (Including Sets/Arrays of Images)
*/
//Upload an Array of Images To The ImgBB Image Database With API and Return The Needed URLs in a string seperated by spaces for storage in Site DB
function uploadImages(array $image_files) {
	//array that accepts each URL from the API after each Image Upload to ImgBB
	$urls_set = array();
	reset($image_files);
	//Based on the Assosiative Array Format of the FILES array, only tmp_name and name are valid identifiers if a new item is available.
	//Using current and next allows simple iteration using a while loop through each entry effectively of the complex assosiative array format of FILES
	while(current($image_files['tmp_name']) != false and current($image_files['name']) != false) {
		$fp = fopen(current($image_files['tmp_name']), "r");
		$image_bytes = fread($fp, filesize(current($image_files['tmp_name'])));
		//Read the image bytes into the post data variable in a format that can be sent through Curl to ImgBB
		$post_data = array("image" => base64_encode($image_bytes), "name" => current($image_files['name']));
		fclose($fp);
		$upload_curl = curl_init();
		curl_setopt($upload_curl, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=796d1b4651773387e79be3b510e261d8');
		curl_setopt($upload_curl, CURLOPT_HEADER, false);
		curl_setopt($upload_curl, CURLOPT_POST, true);
		curl_setopt($upload_curl, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($upload_curl, CURLOPT_RETURNTRANSFER, true);
		$upload = curl_exec($upload_curl);
		curl_close($upload_curl);
		if($upload != false) {
			//convert curl return value to json object to extract the url
			$json = json_decode($upload);
			$url = $json -> data -> display_url;
			//once the url is extracted from the json object, push into the url set and increment current tmp_name and name
			array_push($urls_set, $url);
			next($image_files['tmp_name']);
			next($image_files['name']);
		}
	}
	//convert array of urls to spaced string of urls and return
	$urls_str = implode(" ", $urls_set);
	return $urls_str;
}
?>