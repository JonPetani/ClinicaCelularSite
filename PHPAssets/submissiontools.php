<?php
function uploadImages(array $image_files) {
	$urls_set = array();
	reset($image_files);
	while(current($image_files['tmp_name']) != false and current($image_files['name']) != false) {
		$fp = fopen(current($image_files['tmp_name']), "r");
		$image_bytes = fread($fp, filesize(current($image_files['tmp_name'])));
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
			$json = json_decode($upload);
			$url = $json -> data -> display_url;
			array_push($urls_set, $url);
			next($image_files['tmp_name']);
			next($image_files['name']);
		}
	}
	$urls_str = implode(" ", $urls_set);
	return $urls_str;
}
?>