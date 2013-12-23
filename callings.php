<?php
require $_SERVER['DOCUMENT_ROOT'].'/inc/php/h2o/h2o.php';
date_default_timezone_set('UTC');

$template = new H2o($_SERVER['DOCUMENT_ROOT'].'/inc/tpl/callings.tpl', array(
    'cache_dir' => dirname(__FILE__)
));
$dataDir = $_SERVER['DOCUMENT_ROOT']."/data";

$csv = array();
$display = array();
$display['organizations'] = array();

if (($handle = fopen($dataDir."/organization.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    array_push($csv, $data);
  }
  fclose($handle);
}

# Generate calling array
$callings = array();
foreach($csv as $line) {
  if(!array_key_exists($line[0], $callings)) {
      $callings[$line[0]] = array();
  }
  $callings[$line[0]][] = array(
    "Organization"      => $line[1]
  , "Pos Seq"           => $line[2]
  , "Position"          => $line[3]
  , "Ldrshp"            => $line[4]
  , "Indiv ID"          => $line[5]
  , "Indiv Name"        => $line[6]
  , "Sustained"         => $line[7]
  , "Set Apart"         => $line[8]
  );
}

foreach ($callings as $item) {
  if ($item[0]['Organization'] == "Organization") {
    continue;
  }
  $currentOrg = array(
    'name' => $item[0]['Organization'],
    'callings' => array(),
    'leaders' => array()
  );
  foreach ($item as $subitem) {
    if (($calltime = strtotime($subitem['Sustained'])) === false) {
      $calltime = 999999999999;
    }
    if (empty($subitem['Indiv Name'])) {
      $length = -1;
    } else {
      $length = time() - $calltime;
    }
    $calling = array(
        'name'      => $subitem['Position']
      , 'person'    => $subitem['Indiv Name']
      , 'sustained' => $subitem['Sustained']
      , 'length'    => $length
      , 'setApart'  => $subitem['Set Apart']
      );
    if ($subitem['Ldrshp'] == "Yes") {
      array_push($currentOrg['leaders'],$calling);
    } else {
      array_push($currentOrg['callings'],$calling);
    }
  }
  array_push($display['organizations'], $currentOrg);
}
##############################################################
# Sort according to calling name
foreach ($display['organizations'] as &$array) {
  usort($array["callings"], "cmp");
}


##############################################################
# Display!
echo $template->render($display);

##############################################################
# Functions
##############################################################
function cmp($a, $b) {
  return strnatcmp($a['name'],$b['name']);
}

?>