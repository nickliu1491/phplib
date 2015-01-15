<?php
/**
 * 检查网站是否宕机
 * @param unknown $url
 * @return boolean
 */
function visit($url) {
	$agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_URL, $url );
	curl_setopt ( $ch, CURLOPT_USERAGENT, $agent );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_VERBOSE, false );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 5 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	curl_setopt ( $ch, CURLOPT_SSLVERSION, 3 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	$page = curl_exec ( $ch );
	// echo curl_error($ch);
	$httpcode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
	curl_close ( $ch );
	if ($httpcode >= 200 && $httpcode < 300) {
		return true;
	} else {
		return false;
	}
}
if (visit ( "http://www.google.com" )) {
	echo "Website OK" . "n";
} else {
	echo "Website DOWN";
}