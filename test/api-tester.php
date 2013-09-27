<?php

require_once(__DIR__ . "/../demo/openSRS_LoaderWrapper.php");

$callstring = json_encode(array("func" => "lookupGetBalance"));
$osrsHandler = processOpenSRS ("json", $callstring);

print ("In: ". $callstring . "\n");
print ("Out: ". $osrsHandler->resultFormatted . "\n");