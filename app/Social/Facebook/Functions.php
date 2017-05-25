<?php

function fb($sub_domain, $relative_url = null, $mission = '') {
	$url = 'https://' . $sub_domain . '.facebook.com/';

	if ($sub_domain == 'graph' && $mission == '') {
		$url .= 'v2.9/';
	}

	$url .= $relative_url;

	return $url;
}

function sign_creator($username, $password) {
	$data = array(
		'api_key' => '3e7c78e35a76a9299309885393b02d97',
		'email' => $username,
		'format' => 'JSON',
		'generate_machine_id' => '1',
		'generate_session_cookies' => '1',
		'locale' => 'vi_vn',
		'method' => 'auth.login',
		'password' => $password,
		'return_ssl_resources' => '0',
		'v' => '1.0',
	);

	$sig = "";
	foreach ($data as $key => $value) {
		$sig .= "$key=$value";
	}

	$sig .= 'c1e620fa708a1d5696fb991c1bde5662';
	$sig = md5($sig);
	$data['sig'] = $sig;

	return file_get_contents('https://api.facebook.com/restserver.php?' . http_build_query($data));
}

function randomString($length = 5) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}

function upanh($filename) {
	// Client id: f9274a775d445bc
	// Client secret: aa9145ecae98dae391c9bdf9df9b6ab335b7e2dc
	// access_token: 14fd3b81d912a5f8595cff29691350ea69c07bb2
	// refresh_token: be0a461989eeb6122caa2298ce7bc3102b208cfb
	$curl = curl_init();
	$client_id = 'f9274a775d445bc';

	$handle = fopen($filename, 'r');
	$data = fread($handle, filesize($filename));
	$pvars = array('image' => base64_encode($data));
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.imgur.com/3/image.json',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $pvars,
		CURLOPT_HTTPHEADER => ['Authorization: Client-ID ' . $client_id],
		// CURLOPT_SSL_VERIFYPEER => true,
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response, true)['data']['link'];
}

function handlingfbcode($error) {
	$message = '';
	$error_code = isset($error['error_code']) ? $error['error_code'] : $error['code'];
	switch ($error_code) {
		case 200:
			$message = $error['message'] . '. Có thể thiếu access_token!';
			break;
		case 400:
			$message = $error['error_msg'];
			break;
		default:
			$message = 'Chưa thiết lập error code!';
			break;
	}
	return $message;
}

function validateDate($date, $format = 'd.m.Y H:i') {
	$d = DateTime::createFromFormat($format, $date);
	return $d && $d->format($format) == $date;
}