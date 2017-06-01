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

function stripUnicode($str) {
	if(!$str) return false;
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd'=>'đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i'=>'í|ì|ỉ|ĩ|ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'D'=>'Đ',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
		'' => ' ',
	);
	foreach($unicode as $khongdau => $codau) {
		$str = preg_replace("/($codau)/i", $khongdau, $str);
	}
	return strtolower($str);
}

function random($type, $length = 5) {
	if ($type == 'email') {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters) - 1;
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength)];
		}
		return $randomString;
	} elseif($type == 'string') {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters) - 1;
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength)];
		}
		return $randomString;
	} elseif ($type == 'number') {
		$randomNumber = substr(str_shuffle(str_repeat('0123456789', 3)), 0, $length);
		return $randomNumber;
	} elseif ($type == 'phone') {
		$length = 7;
		$nhamang = ['086', '096', '097', '098', '0162', '0163', '0164', '0165', '0166', '0167', '0168', '0169', '090', '093', '0120', '0121', '0122', '0126', '0128', '091', '094', '0123', '0124', '0125', '0127', '0129'];
		$randomNhamang = $nhamang[mt_rand(0, count($nhamang) - 1)];
		$phone = $randomNhamang . substr(str_shuffle(str_repeat('0123456789', 3)), 0, $length);
		return $phone;
	}
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
		case 405:
			$message = $error['error_msg'] . 'Account có thể bị checkpoint!';
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

function check_proxy($proxy) {
	$proxy_info = explode(':', $proxy);
	$ip = $proxy_info[0];
	$port = $proxy_info[1];

	$ch = curl_init('http://api.proxyipchecker.com/pchk.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'ip='.$ip.'&port='.$port);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 6);
	$result['exe'] = curl_exec($ch);
	$result['err'] = curl_error($ch);
	curl_close($ch);

	$data = explode(';', $result['exe']);
	if (!empty($result['err']) || $data[0] == 0) {
		return ['type' => 'fail', 'error' => "Proxy die: $proxy"];
	}

	return ['type' => 'success', 'proxy' => $proxy, 'response_time' => $data[0]];
}

function regclone($proxy, $data, $url, $referer, $agent) {
	$timeout = 5;

	$proxy_info = explode(':', $proxy);
	$ip = $proxy_info[0];
	$port = $proxy_info[1];

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_REFERER, $referer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_PROXY, $ip);
	curl_setopt($ch, CURLOPT_PROXYPORT, $port);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	if (!empty($data)) {
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}

	$result['exe'] = curl_exec($ch);
	$result['err'] = curl_error($ch);

	curl_close($ch);
	return $result;
}