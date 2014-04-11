<?php
$callArray = array (
        "func" => "cookieSet",
        "data" => array (
                "reg_username" => "clam",
		"reg_password" => "abc123",
		"domain" => "aaadec02.com"
        )
);

require_once(__DIR__ . "/openSRS_LoaderWrapper.php");

$callstring = json_encode($callArray);
$osrsHandler = processOpenSRS ("json", $callstring);

echo (" In: ". $callstring ."<br>");
echo ("Out: ". $osrsHandler->resultFormatted);
?>
