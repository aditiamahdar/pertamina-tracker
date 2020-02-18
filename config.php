<?php
$dbconfig = [
  'host' => 'localhost',
  'username' => 'patra',
  'password' => 'P4tra@MySql#1',
  'name' => 'ppn_data'
];
// $dbconfig = [
//   'host' => 'localhost',
//   'username' => 'root',
//   'password' => 'root',
//   'name' => 'pertamina_tracker'
// ];

$mysqli = new mysqli($dbconfig['host'], $dbconfig['username'], $dbconfig['password'], $dbconfig['name']);

// Check connection
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

function escape_map($val){
  return $GLOBALS['mysqli']->escape_string($val);
}

function latitude($hdegree, $minutes){
  $hemisphere = substr($hdegree, 0, 1) == 'S' ? -1 : 1;
  $degree = substr($hdegree, 1);
  $latitude = $hemisphere * ($degree + ($minutes / 60));
  return $latitude;
}

function longitude($hdegree, $minutes){
  $hemisphere = substr($hdegree, 0, 1) == 'E' ? 1 : -1;
  $degree = substr($hdegree, 1);
  $longitude = $hemisphere * ($degree + ($minutes / 60));
  return $longitude;
}

function latlong($coordinate){
  $coordinates = explode(' ', $coordinate);
  $latitude = latitude($coordinates[0], $coordinates[1]);
  $longitude = latitude($coordinates[2], $coordinates[3]);
  $latlong = [
    'latitude' => $latitude,
    'longitude' => $longitude
  ];
  return $latlong;
}

function urlData($key){
  if (!isset($_GET[$key])) return null;

  $array = array_map('escape_map', explode(',', $_GET[$key]));
  return implode("','",$array);
}
?>
