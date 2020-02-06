<?php
// https://api.fleetsight.dev/patra/track/show?token=0a5ee3075e70ba3e87dc8c3fe27ac93a0F75C1C09354813D4BA03615FEB37B914E4EC9D7&from=2020-01-06T03:00:00&to=2020-01-06T04:30:00&mt=B9714SFU

// include('/home/admin/php/wialon.php');
include('wialon.php');

// $in_token = '0a5ee3075e70ba3e87dc8c3fe27ac93a0F75C1C09354813D4BA03615FEB37B914E4EC9D7';
$in_token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_URL);
$in_from = filter_input(INPUT_GET, 'from');
$in_to = filter_input(INPUT_GET, 'to');
$in_mt = filter_input(INPUT_GET, 'mt', FILTER_SANITIZE_URL);

$from = str_replace(' ', 'T', $in_from);
// $from = str_replace(' ', 'T', $from);

$to = str_replace(' ', 'T', $in_to);
// $to = str_replace(' ', 'T', $to);


if (isset($in_token)){
	$wialon_api = new Wialon();

	$token = $in_token;
	$login = $wialon_api->login($token);
	$json = json_decode($login, true);
	if(!isset($json['error'])){

		$params = array(
		);

		$result = $wialon_api->core_create_auth_hash(json_encode($params));

		$result_array = json_decode($result,true);

		$process_array = array();

		$wialon_api->logout();

		// $send_array = array();
		// $send_array = json_encode($process_array);
		// echo $send_array;
		// print_r($result_array);
		// echo json_encode($result_array['authHash']);
		$auth_Hash= $result_array['authHash'];

		// echo "\n";

	} else {
		echo WialonError::error($json['error']);
		echo "Invalid Parameter";
	}
}else{
	echo "Access Denied";
}

$autoplay = 1;
$domain = "https://tracker.viralab.id";
// $domain = "http://localhost:8888";
$redirect_to = "Location: ".$domain."?authHash=".$auth_Hash."&from=".$from."&to=".$to."&mt=".$in_mt."&autoplay=".$autoplay;

header($redirect_to);
die();
?>
