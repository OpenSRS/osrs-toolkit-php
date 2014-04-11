<?php
$callArray = array (
        "func" => "subresGet",
        "data" => array (
                "username" => "clamsub10"
        )
);

require_once(__DIR__ . "/openSRS_LoaderWrapper.php");

$callstring = json_encode($callArray);

$osrsHandler = processOpenSRS ("json", $callstring);

echo (" In: ". $callstring ."<br>");
echo ("Out: ". $osrsHandler->resultFormatted);
?>
