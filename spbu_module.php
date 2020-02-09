<?php
function spbuData($array_cond){
  if (empty($array_cond)) return [];

  $query = "SELECT no, spbu, coordinate FROM spbu WHERE spbu IN ('".$array_cond."')";
  $result = $GLOBALS['mysqli']->query($query);
  $rows = [];
  while($row = $result->fetch_assoc()) {
    $latlong = latlong($row['coordinate']);
    $row['latitude'] = $latlong['latitude'];
    $row['longitude'] = $latlong['longitude'];
    array_push($rows, $row);
  }
  return $rows;
}

$spbu_array = urlData('spbu');
$spbu_rows = spbuData($spbu_array);
?>
