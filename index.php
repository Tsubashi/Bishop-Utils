<?php
require 'h2o/h2o.php';
date_default_timezone_set('UTC');

$template = new H2o('callings.tpl', array(
    'cache_dir' => dirname(__FILE__)
));

$csv = array();
$display = array();
$display['organizations'] = array();

if (($handle = fopen("organization.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    array_push($csv, $data);
  }
  fclose($handle);
}


$result = array();
foreach($csv as $item) {
    if(!array_key_exists($item[0], $result)) {
        $result[$item[0]] = array();
    }
    $result[$item[0]][] = $item;
}

/*
 0 - "Org Seq"
 1 - "Organization"
 2 - "Pos Seq"
 3 - "Position"
 4 - "Ldrshp"
 5 - "Indiv ID"
 6 - "Indiv Name"
 7 - "Sustained"
 8 - "Set Apart"
*/


foreach ($result as $item) {
  if ($item[0][1] == "Organization") {
    continue;
  }
  $currentOrg = array(
    'name' => $item[0][1],
    'callings' => array(),
    'leaders' => array()
  );
  foreach ($item as $subitem) {
    if (($calltime = strtotime($subitem[7])) === false) {
      $calltime = 999999999999;
    }
    if (empty($subitem[6])) {
      $length = -1;
    } else {
      $length = time() - $calltime;
    }
    $calling = array(
        'name'      => $subitem[3]
      , 'person'    => $subitem[6]
      , 'sustained' => $subitem[7]
      , 'length'    => $length
      , 'setApart'  => $subitem[8]
      );
    if ($subitem[4] == "Yes") {
      array_push($currentOrg['leaders'],$calling);
    } else {
      array_push($currentOrg['callings'],$calling);
    }
  }
  array_push($display['organizations'], $currentOrg);
}
echo $template->render($display);

?>