<?php
// https://api.fleetsight.dev/patra/track/show?token=0a5ee3075e70ba3e87dc8c3fe27ac93a0F75C1C09354813D4BA03615FEB37B914E4EC9D7&from=2020-01-06T03:00:00&to=2020-01-06T04:30:00&mt=B9714SFU

// include('/home/admin/php/wialon.php');
include('wialon.php');

$in_token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_URL);
$in_from = filter_input(INPUT_GET, 'from');
$in_to = filter_input(INPUT_GET, 'to');
$in_mt = filter_input(INPUT_GET, 'mt', FILTER_SANITIZE_URL);
$spbu = filter_input(INPUT_GET, 'spbu', FILTER_SANITIZE_URL);

$from = str_replace(' ', 'T', $in_from);
$to = str_replace(' ', 'T', $in_to);
$autoplay = 1;
$domain = "https://tracker.viralab.id";
// $domain = "http://localhost:8888";

// Check token presence
if (!isset($in_token)) die("Access Denied");

$wialon_api = new Wialon();
$login = $wialon_api->login($in_token);
$json = json_decode($login, true);

// Check token validity
if (isset($json['error'])) die("Invalid Token: " . WialonError::error($json['error']));

// Get auth hash
$params = array();
$result = $wialon_api->core_create_auth_hash(json_encode($params));
$result_array = json_decode($result, true);
$auth_Hash = $result_array['authHash'];
$wialon_api->logout();

// Redirect to track player page
$redirect_to = "Location: ".$domain."?authHash=".$auth_Hash."&from=".$from."&to=".$to."&mt=".$in_mt."&autoplay=".$autoplay."&spbu=".$spbu;
header($redirect_to);
die();
?>
