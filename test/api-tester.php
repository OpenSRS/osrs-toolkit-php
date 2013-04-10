<?php

require_once dirname(__FILE__) . "/../opensrs/openSRS_loader.php";

$callstring = json_encode(array("func" => "lookupGetBalance"));
$osrsHandler = processOpenSRS ("json", $callstring);

print ("In: ". $callstring . "\n");
print ("Out: ". $osrsHandler->resultFormatted . "\n");