<?php

function mkurl($is_ssl, $sub_domain, $host, $relative_url = null, $fields = []) {
	$url = ($is_ssl === true ? 'https://' : 'http://') . (!empty($sub_domain) ? $sub_domain . '.' : null) . $host . '/' . (!empty($relative_url) ? $relative_url : null);
	if (!empty($fields)) {
		$url .= '?';
		$len = count($fields)-1;
		foreach ($fields as $key => $field) {
			$url .= "$key=$field" . ($field === end($fields) ? null : '&');
		}
	}
	return $url;
}

function sign_creator($username, $password) {
	$data = array(
		// 'api_key' => '882a8490361da98702bf97a021ddc14d', // fb for android
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
	// $sig .= '62f8ce9f74b12f84c123cc23437a4a32';
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

function convert_cookie($session_cookies) {
	$cookie = '';
	for ($i = 0; $i < 2; $i++) {
		$cookie .= $session_cookies[$i]['name'] . '=' . $session_cookies[$i]['value'] . ';';
	}
	return $cookie;
}

function arr_sort($array, $on, $order=SORT_ASC)
{
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
			break;
			case SORT_DESC:
				arsort($sortable_array);
			break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}

	return $new_array;
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

function clone_info() {
	$url = 'https://uinames.com/api/?region=vietnam&ext';
	$info = json_decode(Curl::to($url)->get(), true);

	$user['firstname'] = $info['surname'];
	$user['lastname'] = $info['name'];
	$user['full_name'] = $info['surname'] . ' ' . $info['name'];
	$user['name'] = stripUnicode($user['full_name']) . '.' . random('email', 3) . '_' . random('number', 3);
	$user['email'] = $user['name'] . '@pulpmail.us';
	$user['pass'] = random('string', 10);
	$user['phone'] = random('phone');
	$user['gender'] = $info['gender'] === 'female' ? 0 : 1;
	$dob = explode('/', $info['birthday']['dmy']);
	$user['d'] = $dob[0];
	$user['m'] = $dob[1];
	$user['y'] = $dob[2];
	return json_encode($user, JSON_UNESCAPED_UNICODE);
}