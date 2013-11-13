<?php
require $_SERVER['DOCUMENT_ROOT'].'/inc/php/h2o/h2o.php';
date_default_timezone_set('UTC');

$template = new H2o($_SERVER['DOCUMENT_ROOT'].'/inc/tpl/radar.tpl', array(
    'cache_dir' => dirname(__FILE__)
));
$dataDir = $_SERVER['DOCUMENT_ROOT']."/data";


# REQUEST specific variables
$months_forward = (isset($_REQUEST["depth"]) && is_numeric($_REQUEST["depth"])) ? $_REQUEST["depth"] : 6;
$months_backward = (isset($_REQUEST["past_depth"]) && is_numeric($_REQUEST["past_depth"])) ? $_REQUEST["past_depth"] : 3;

$radar_depth = strtotime("+".$months_forward." Months");
$past_depth = strtotime("-".$months_backward." Months");

# General Variables
$Membership = array();
$organization = array();
$display = array();
$display['items'] = array();
$display['depth'] = array();
$display['depth']['future'] = $months_forward;
$display['depth']['past']   = $months_backward;
$display['depth']['submit'] = $_SERVER['PHP_SELF'];
$display['title'] ="Bishop's Radar (+$months_forward/-$months_backward)";

# Read in Data
if (($handle = fopen($dataDir."/Membership.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    array_push($Membership, $data);
  }
  fclose($handle);
}

if (($handle = fopen($dataDir."/organization.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    array_push($organization, $data);
  }
  fclose($handle);
}

# Generate member array
$members = array();
foreach($Membership as $line) {
  $members[$line[0]] = array(
    "Full Name"         => $line[1]
  , "Preferred Name"    => $line[2]
  , "HofH ID"           => $line[3]
  , "HH Position"       => $line[4]
  , "HH Order"          => $line[5]
  , "Household Phone"   => $line[6]
  , "Individual Phone"  => $line[7]
  , "Household E-mail"  => $line[8]
  , "Individual E-mail" => $line[9]
  , "Street 1"          => $line[10]
  , "Street 2"          => $line[11]
  , "D/P"               => $line[12]
  , "City"              => $line[13]
  , "Postal"            => $line[14]
  , "State/Prov"        => $line[15]
  , "Country"           => $line[16]
  , "2Street 1"         => $line[17]
  , "2Street 2"         => $line[18]
  , "2D/P"              => $line[19]
  , "2City"             => $line[20]
  , "2Zip"              => $line[21]
  , "2State/Prov"       => $line[22]
  , "2Country"          => $line[23]
  , "Ward Geo Code"     => $line[24]
  , "Stake Geo Code"    => $line[25]
  , "Sex"               => $line[26]
  , "Birth"             => $line[27]
  , "Baptized"          => $line[28]
  , "Confirmed"         => $line[29]
  , "Endowed"           => $line[30]
  , "Rec Exp"           => $line[31]
  , "Priesthood"        => $line[32]
  , "Mission"           => $line[33]
  , "Married"           => $line[34]
  , "Spouse Member"     => $line[35]
  , "Sealed to Spouse"  => $line[36]
  , "Sealed to Prior"   => $line[37]
  );
}

##############################################################
# Add in today
array_push($display["items"],array(
        "date"  => time()
      , "name"  => "---------- Today ----------"
      , "type"  => "Today"
      , "class" => "Today"
      ));
      
##############################################################
# Show the report's start day
array_push($display["items"],array(
        "date"  => $past_depth
      , "name"  => "---------- START ----------"
      , "type"  => "START"
      , "class" => "Today"
      ));
      
##############################################################
# Show the report's end day
array_push($display["items"],array(
        "date"  => $radar_depth
      , "name"  => "---------- END ----------"
      , "type"  => "END"
      , "class" => "Today"
      ));
  
##############################################################
# Age Based Items
foreach($members as $member) {
  $advancementTimes = array(
      "Baptism"     => strtotime("+8 Years",strtotime($member["Birth"]))
    , "12 Yr. Adv." => strtotime("+12 Years",strtotime($member["Birth"]))
    , "14 Yr. Adv." => strtotime("+14 Years",strtotime($member["Birth"]))
    , "16 Yr. Adv." => strtotime("+16 Years",strtotime($member["Birth"]))
    );
  foreach($advancementTimes as $type => $time) {
    if (isOnRadar($time)) {
      array_push($display["items"],array(
          "date"  => $time
        , "name"  => $member["Preferred Name"]
        , "type"  => $type
        , "class" => str_replace(".", "", str_replace(" ", "_", $type))
        ));
    }
  }
}

##############################################################
# Quarterly Reports
$reportTimes = array(
      strtotime("15 January")
    , strtotime("15 April")
    , strtotime("15 July")
    , strtotime("15 October")
    );
foreach($reportTimes as $rpt) {
  addAllInRange($display['items'],"Quarterly Report",$rpt,"Report","Report");
}

##############################################################
# Show the start of each month
$months = array(
      "January"   => strtotime("01 January")
    , "February"  => strtotime("01 February")
    , "March"     => strtotime("01 March")
    , "April"     => strtotime("01 April")
    , "May"       => strtotime("01 May")
    , "June"      => strtotime("01 June")
    , "July"      => strtotime("01 July")
    , "August"    => strtotime("01 August")
    , "September" => strtotime("01 September")
    , "October"   => strtotime("01 October")
    , "November"  => strtotime("01 November")
    , "December"  => strtotime("01 December")
    );
foreach($months as $name => $time) {
  addAllInRange($display['items'],"",$time,$name,"Month");
}

##############################################################
# Sort according to date
usort($display["items"], "cmp");
foreach ($display["items"] as &$item) {
  $item["dateString"] = date('d M Y', $item["date"]);
}

##############################################################
# Display!
echo $template->render($display);


##############################################################
# Functions
##############################################################
function cmp($a, $b) {
  return $a['date'] - $b['date'];
}

function isOnRadar($time) {
  global $past_depth, $radar_depth;
  return ($time > $past_depth && $time < $radar_depth);
}

function addAllInRange(&$array,$name,$date,$type,$class="") {
  global $past_depth, $radar_depth;
  
  if ($class === "") {
    $class = str_replace(".", "", str_replace(" ", "_", $type));
  }
  #Iterate forward
  $i = 0;
  while(strtotime("+$i Years",$date) < $radar_depth) {
    $time = strtotime("+$i Years",$date);
    if (isOnRadar($time)) {
    array_push($array,array(
        "date"  => $time
      , "name"  => $name
      , "type"  => $type
      , "class" => $class
      ));
    }
    $i++;
  }
  
  #Iterate backward
  $i = 1;
  while(strtotime("-$i Years",$date) > $past_depth) {
    $time = strtotime("-$i Years",$date);
    if (isOnRadar($time)) {
    array_push($array,array(
        "date"  => $time
      , "name"  => $name
      , "type"  => $type
      , "class" => $class
      ));
    }
    $i++;
  }
}

?>