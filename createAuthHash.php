<?php

//https://api.fleetsight.dev/patra/getLocationAll?token=0a5ee3075e70ba3e87dc8c3fe27ac93aDB572EFE41530582B70ECD3CFACC0F18D8E82E3B

include('wialon.php');

$in_token = '0a5ee3075e70ba3e87dc8c3fe27ac93a0F75C1C09354813D4BA03615FEB37B914E4EC9D7';

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
		echo json_encode($result_array['authHash']);
		echo "\n";

	} else {
		echo WialonError::error($json['error']);
		echo "Invalid Parameter";
	}


}else{
	echo "Access Denied";
}

?>
