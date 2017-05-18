<?php

function fb($sub_domain, $relative_url=null) {
	$url = 'https://' . $sub_domain . '.facebook.com/';

	if ($sub_domain == 'graph') $url .= 'v2.9/';
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
