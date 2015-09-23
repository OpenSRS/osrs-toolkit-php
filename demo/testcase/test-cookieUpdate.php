<?php 

if (isset($_POST['function'])) {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';
    // Form data capture
    $formFormat = $_POST['format'];

    // Put the data to the Formatted array
    $callstring = '';
    $callArray = array(
        'func' => $_POST['function'],
        'data' => array(
            'reg_username' => $_POST['reg_username'],
            'reg_password' => $_POST['reg_password'],
            'domain' => $_POST['domain'],
            'domain_new' => $_POST['domain_new'],
            'cookie' => $_POST['cookie'],
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
    echo('Out: '.$osrsHandler->resultFullFormatted);
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

<form action="test-cookieUpdate.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="cookieUpdate">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%">
				<span class="headLine">Username </span> <input type="text" name="reg_username" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td width="100%">
				<span class="headLine">Password </span> <input type="text" name="reg_password" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td class="searchBoxText" width="100%">
				<span class="headLine">Cookie Code </span> <input type="text" name="cookie" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td class="searchBoxText" width="100%">
				<span class="headLine">Old Domain </span> <input type="text" name="domain" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td class="searchBoxText" width="100%">
				<span class="headLine">New Domain </span> <input type="text" name="domain_new" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td><input value="Update Cookie" id="lookupSearch" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
