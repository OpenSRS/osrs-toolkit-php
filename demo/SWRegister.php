<?php

$callArray = array(
    'func' => 'trustSWregister',

    'data' => array(
        'reg_type' => '',
        'product_type' => '',
        'personal' => array(
            'first_name' => '',
            'last_name' => '',
            'address1' => '',
            'address2' => '',
            'address3' => '',
            'title' => '',
            'city' => '',
            'state' => '',
            'postal_code' => '',
            'country' => '',
            'phone' => '',
            'fax' => '',
            'email' => '',
            ),
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
