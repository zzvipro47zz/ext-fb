<?php

function fb($sub_domain = 'www', $relative_url) {
	$url = 'https://' . $sub_domain . '.facebook.com/';

	if ($relative_url) {
		$url = $url . $relative_url;
	}
	
	return $url;
}