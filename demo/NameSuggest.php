<?php

$callArray = array(
    'func' => 'lookupNameSuggest',

    'data' => array(
        'domain' => 'hockey.com',

        // Only need to pass one of these 
        // <-----
            // Name Suggestion Choice Check
        'nsselected' => '.com;.net;.org',

            // Lookup Choice Check
            // 'lkselected' => '.com;.net;.org', 

            // Get Default Name Suggestion Choices For No Form Submission
            // 'allnsdomains' => '.com;.net;.org', 

            // Get Default Lookup Choices For No Form Submission
            // 'alllkdomains' => '.com;.net;.org'
        // ----->
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
