<?php

$callArray = array(
    'func' => 'premiumDomain',
    //"func" => "allinone",
        //"func" => "premiumDomain",

        'data' => array(
                'domain' => 'hockey.com',
        // These are optional
                'selected' => '.com;.net;.org',
                'alldomains' => '.com;.net;.org',
        ),
);

// require_once '../opensrs/openSRS_loader.php';
require __DIR__.'/../vendor/autoload.php';
use opensrs\Request;

//JSON
// $callstring = json_encode($callArray);

$json = '{"func":"provSWregister","data":{"auto_renew":0,"domain":"serviciosprofesionales.live","handle":"process","f_lock_domain":1,"f_whois_privacy":false,"reg_type":"new","reg_username":99391876,"reg_password":"ignore.that","period":1,"custom_tech_contact":1,"custom_nameservers":1,"name1":"ns1.wordpress.com","name2":"ns2.wordpress.com","name3":"ns3.wordpress.com","sortorder1":1,"sortorder2":2,"sortorder3":3,"personal":{"first_name":"Roberto","last_name":"Salinas","org_name":null,"address1":"5ta calle pte, Barrio San Miguel","address2":null,"city":"Ilobasco","state":"Cabanas","postal_code":"503","country":"SV","phone":"50378284690","fax":null,"email":"laptopsalinas@gmail.com"}}}';

try {
    $request = new Request();
    $osrsHandler = $request->process('json', $json);
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
} catch (\opensrs\Exception $e) {
    var_dump($e->getMessage());
} catch(\opensrs\APIException $e) {
    var_dump($e->getMessage());
    var_dump($e->getInfo());
}
