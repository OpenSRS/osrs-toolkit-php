<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\Request;

if (isset($_POST['function'])) {

// ONLY FOR TESTING PURPOSE!!!
// require_once dirname(__FILE__) . "/../../opensrs/spyc.php";

// !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!

// Form data capture - ONLY FOR TESTING PURPOSE!!!
$formSelectedDomainArray = array();
    $allDomainArray = array('.co.uk','.me','.org','.asia','.org.uk','.net','.tel','.com','.mobi','.biz','.info','.ca');
    $formFormat = $_POST['format'];
    $formFunction = $_POST['function'];
    $formSearchWord = $_POST['domain'];

    for ($i = 0; $i <= 50; ++$i) {
        if (isset($_POST['tld_'.$i])) {
            array_push($formSelectedDomainArray, $_POST['tld_'.$i]);
        }
    }

// Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
$callstring = '';
    $callArray = array(
    'func' => $formFunction,
    'data' => array(
        'domain' => $formSearchWord,
                'maximum' => $_POST['max'],
        'selected' => implode(';', $formSelectedDomainArray),
        'defaulttld' => implode(';', $allDomainArray),
    ),
);

    if ($formFormat == 'json') {
        $callstring = json_encode($callArray);
    }
    if ($formFormat == 'yaml') {
        $callstring = Spyc::YAMLDump($callArray);
    }

// Open SRS Call -> Result
require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

    try {
        $request = new Request();
        $osrsHandler = $request->process('json', json_encode($callArray));

    // var_dump($osrsHandler->resultRaw);
    echo $osrsHandler->resultFormatted;
    } catch (\opensrs\Exception $e) {
        var_dump($e->getMessage());
    }

// $osrsHandler = processOpenSRS ($formFormat, $callstring);
//
//
// // Print out the results
// echo (" In: ". $callstring ."<br>");
// echo ("Out: ". $osrsHandler->resultFormatted);
//
//
// } else {
// 	// Format
// 	if (isSet($_GET['format'])) {
// 		$tf = $_GET['format'];
// 	} else {
// 		$tf = "json";
// 	}
} else {
    ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title></title>
	<meta name="generator" http-equiv="generator" content="Claire Lam" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en"/>
</head>
<body>


<form action="test-premiumDomain.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="premiumDomain">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr class="searchBox">
		<td class="searchBoxText" width="100%">
			<span class="headLine">Premium Domain</span><br>
			<input type="text" name="domain" id="domain" value="" class="frontBox"><br>
                        <span class="headLine">Max Number of Results </span>
                        <input type="text" name="max" id="max" value="" class="frontBox"><br>
		</td>
	</tr>
	<tr>
		<td width="100%"><table class="searchBoxText" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%"><div>
					<div class="fronttld"><input name="tld_1" id="tld_1" value=".co.uk" type="checkbox"> .co.uk</div>
					<div class="fronttld"><input name="tld_2" id="tld_2" value=".me" type="checkbox"> .me</div>
					<div class="fronttld"><input name="tld_3" id="tld_3" value=".org" type="checkbox"> .org</div>
					<div class="fronttld"><input name="tld_4" id="tld_4" value=".asia" type="checkbox"> .asia</div>
					<div class="fronttld"><input name="tld_5" id="tld_5" value=".org.uk" type="checkbox"> .org.uk</div>
					<div class="fronttld"><input name="tld_6" id="tld_6" value=".net" type="checkbox"> .net</div>
					<div class="fronttld"><input name="tld_7" id="tld_7" value=".tel" type="checkbox"> .tel</div>
					<div class="fronttld"><input name="tld_8" id="tld_8" value=".com" type="checkbox"> .com</div>
					<div class="fronttld"><input name="tld_9" id="tld_9" value=".mobi" type="checkbox"> .mobi</div>
					<div class="fronttld"><input name="tld_10" id="tld_10" value=".biz" type="checkbox"> .biz</div>
					<div class="fronttld"><input name="tld_11" id="tld_11" value=".info" type="checkbox"> .info</div>
					<div class="fronttld"><input name="tld_12" id="tld_12" value=".ca" type="checkbox"> .ca</div>
				</div></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td><input value="Check" id="lookupSearch" type="submit"></td>
	</tr>
</table>
</form>


	
</body>
</html>



<?php 
}
?> 
