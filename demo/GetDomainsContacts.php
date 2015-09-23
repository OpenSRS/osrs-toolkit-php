<?php

$callArray = array(
    'func' => 'lookupGetDomainsContacts',

    'data' => array(
        'domain_list' => 'hockey.com,hockey1.com',
        ),
    );

require __DIR__.'/../vendor/autoload.php';
use opensrs\Request;

try {
    $request = new Request('array', $callArray);
    $osrsHandler = $request->process('array', $callArray);

    var_dump($osrsHandler->resultRaw);
} catch (\opensrs\Exception $e) {
    var_dump($e->getMessage());
}
