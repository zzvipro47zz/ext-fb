<?php

if($_GET) $_POST = $_GET;

function sign_creator(){
	$data = array(
		"api_key" => "3e7c78e35a76a9299309885393b02d97",
		"email" => @$_POST['u'],
		"format" => "JSON",
		"generate_machine_id" => "1",
		"generate_session_cookies" => "1",
		"locale" => "vi_vn",
		"method" => "auth.login",
		"password" => @$_POST['p'],
		"return_ssl_resources" => "0",
		"v" => "1.0"
	);

	$sig = "";
	foreach($data as $key => $value){
		$sig .= "$key=$value";
	}
	$sig .= 'c1e620fa708a1d5696fb991c1bde5662';
	$sig = md5($sig);
	$data['sig'] = $sig;

	return file_get_contents("https://api.facebook.com/restserver.php?".http_build_query($data));
}

echo sign_creator();
