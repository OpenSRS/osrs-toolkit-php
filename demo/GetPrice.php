<?php

$callArray = array(
    'func' => 'lookupGetPrice',

    'data' => array(
            'domain' => 'hockey.com',
    ),
);

require __DIR__.'/../vendor/autoload.php';
use opensrs\Request;

try {
    $request = new Request();
    $osrsHandler = $request->process('array', $callArray);

    var_dump($osrsHandler->resultRaw);
} catch (\opensrs\Exception $e) {
    var_dump($e->getMessage());
}
