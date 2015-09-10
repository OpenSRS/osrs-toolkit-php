<?php

$callArray = array (
	'func' => 'premiumDomain',
	//"func" => "allinone",
        //"func" => "premiumDomain",

        'data' => array (
                'domain' => 'hockey.com',
		// These are optional
                'selected' => '.com;.net;.org',
                'alldomains' => '.com;.net;.org', 
        ),
);

// require_once '../opensrs/openSRS_loader.php';
require __DIR__ . '/../vendor/autoload.php';
use OpenSRS\Request;


//JSON
// $callstring = json_encode($callArray);
// $osrsHandler = processOpenSRS ('json', $callstring);

try {
    $request = new Request();
    $osrsHandler = $request->process('array', $callArray);
    // $osrsHandler = $request->process('json', $callstring);

    var_dump($osrsHandler->resultRaw);

    //YAML
    // $callstring = Spyc::YAMLDump($callArray);
    // $osrsHandler = processOpenSRS ("yaml", $callstring);

    //$callstring = XML($callArray);
    //$osrsHandler = processOpenSRS ("xml", $callstring);

    // echo (' In: '.$callstring.'<br>');
    //echo ("Out Result Full Raw: ". $osrsHandler->resultFullRaw ."<br>");
    //echo ("Out Results Formatted: ". $osrsHandler->resultFormatted ."<br>");

    //Array
    // $variable = var_dump($osrsHandler->resultRaw, true);
    // $variable = str_replace ("\n", "<br>\n",  $variable);
    // echo ('Out Results Formatted: '.$variable);
}
catch(\OpenSRS\Exception $e) {
    var_dump($e->getMessage());
}
