<?php 

if (isset($_POST['function'])) {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

// !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!

// Form data capture - ONLY FOR TESTING PURPOSE!!!
$formnsSelectedDomainArray = array(); // Name Suggestion Array
$formlkSelectedDomainArray = array(); // Lookup Array
$allnsDomainArray = array('.com','.net','.org','.info','.biz','.us','.mobi');
    $alllkDomainArray = array('.co.uk','.me','.org','.asia','.org.uk','.net','.tel','.com','.mobi','.biz','.info','.ca');
    $formFormat = $_POST['format'];
    $formFunction = $_POST['function'];
    $formSearchWord = $_POST['domain'];

    for ($i = 0; $i <= 50; ++$i) {
        if (isset($_POST['nstld_'.$i])) {
            array_push($formnsSelectedDomainArray, $_POST['nstld_'.$i]);
        }
        if (isset($_POST['lktld_'.$i])) {
            array_push($formlkSelectedDomainArray, $_POST['lktld_'.$i]);
        }
    }

// Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
$callstring = '';
    $callArray = array(
    'func' => $formFunction,
    'data' => array(
        'domain' => $formSearchWord,
                'maximum' => $_POST['max'],
        'nsselected' => implode(';', $formnsSelectedDomainArray),
        'lkselected' => implode(';', $formlkSelectedDomainArray),
        'allnsdomains' => implode(';', $allnsDomainArray),
        'alllkdomains' => implode(';', $alllkDomainArray),
    ),
);

    if ($formFormat == 'json') {
        $callstring = json_encode($callArray);
    }
    if ($formFormat == 'yaml') {
        $callstring = Spyc::YAMLDump($callArray);
    }

// Open SRS Call -> Result
$osrsHandler = processOpenSRS($formFormat, $callstring);

// Print out the results
echo(' In: '.$callstring.'<br>');
    echo('Out: '.$osrsHandler->resultFormatted);
} else {
    // Format
    if (isset($_GET['format'])) {
        $tf = $_GET['format'];
    } else {
        $tf = 'json';
    }
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


<form action="test-lookupNameSuggest.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="lookupnamesuggest">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr class="searchBox">
		<td class="searchBoxText" width="100%">
			<span class="headLine">Lookup / Suggest Doamins</span><br>
			<input type="text" name="domain" id="domain" value="" class="frontBox"><br>
                </td>
        </tr>
        <tr><td><br><span class="headLine"><b>Name Suggestion Options</b></span></td></tr>
        <tr><td> 
                        <span class="headLine">Max Number of Suggestion Results </span>
                        <input type="text" name="max" id="max" value="" class="frontBox"><br>
		</td>
	</tr>
	<tr>
	<tr><td>Name Suggestion TLD Choices:</td></tr>
		<td width="100%"><table class="searchBoxText" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%"><div>
					<div class="fronttld"><input name="nstld_2" id="nstld_2" value=".com" type="checkbox"> .com</div>
					<div class="fronttld"><input name="nstld_3" id="nstld_3" value=".net" type="checkbox"> .net</div>
					<div class="fronttld"><input name="nstld_4" id="nstld_4" value=".org" type="checkbox"> .org</div>
					<div class="fronttld"><input name="nstld_5" id="nstld_5" value=".info" type="checkbox"> .info</div>
					<div class="fronttld"><input name="nstld_6" id="nstld_6" value=".biz" type="checkbox"> .biz</div>
					<div class="fronttld"><input name="nstld_7" id="nstld_7" value=".us" type="checkbox"> .us</div>
					<div class="fronttld"><input name="nstld_8" id="nstld_8" value=".mobi" type="checkbox"> .mobi</div>
				</div></td>
			</tr>
		</table></td>
        </tr>
	<tr><td><br><span class="headLine"><b>Lookup TLD Options:</b></span></td></tr>
        <tr>
		<td width="100%"><table class="searchBoxText" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="100%"><div>
					<div class="fronttld"><input name="lktld_2" id="lktld_2" value=".com" type="checkbox"> .com</div>
					<div class="fronttld"><input name="lktld_3" id="lktld_3" value=".net" type="checkbox"> .net</div>
					<div class="fronttld"><input name="lktld_4" id="lktld_4" value=".tel" type="checkbox"> .tel</div>
					<div class="fronttld"><input name="lktld_5" id="lktld_5" value=".ca" type="checkbox"> .ca</div>
					<div class="fronttld"><input name="lktld_6" id="lktld_6" value=".eu" type="checkbox"> .eu</div>
					<div class="fronttld"><input name="lktld_7" id="lktld_7" value=".co.uk" type="checkbox"> .co.uk</div>
					<div class="fronttld"><input name="lktld_8" id="lktld_8" value=".de" type="checkbox"> .de</div>
				</div></td>
			</tr>
		</table></td>
	</tr>
	<tr>
		<td><br><input value="Submit Request" id="lookupSearch" type="submit"></td>
	</tr>
</table>
</form>


	
</body>
</html>



<?php 
}
?> 
