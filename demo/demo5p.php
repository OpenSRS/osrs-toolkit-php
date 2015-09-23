<?php 

if (isset($_POST['func'])) {
    require_once '../opensrs/openSRS_loader.php';

    // !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!

    $format = $_POST['format'];
    $function = $_POST['func'];
    $domain = $_POST['domain'];
    $tlds = implode(';', $_POST['tld']);

    // Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
    $callstring = '';
    $callArray = array(
        'func' => $function,
        'data' => array(
            'domain' => $domain,
            'selected' => $tlds,
        ),
    );

    if ($format == 'json') {
        $callstring = json_encode($callArray);
    }
    if ($format == 'yaml') {
        $callstring = Spyc::YAMLDump($callArray);
    }

    // Open SRS Call -> Result
    $osrsHandler = processOpenSRS($format, $callstring);

    $jsonRet = $osrsHandler->resultRaw;
    echo json_encode($jsonRet);
} else {
    echo('<h2>Invalid call!</h2>');
}
?> 
