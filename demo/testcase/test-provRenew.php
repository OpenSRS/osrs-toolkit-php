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
            'auto_renew' => $_POST['auto_renew'],
            'f_parkp' => $_POST['f_parkp'],
            'currentexpirationyear' => $_POST['currentexpirationyear'],
            'handle' => $_POST['handle'],
            'domain' => $_POST['domain'],
            'period' => $_POST['period'],
            'affiliate_id' => $_POST['affiliate_id'],
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

<form action="test-provRenew.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="provRenew">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">auto_renew </span> <input type="text" name="auto_renew" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">f_parkp </span> <input type="text" name="f_parkp" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">currentexpirationyear </span> <input type="text" name="currentexpirationyear" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">handle </span> <input type="text" name="handle" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">period </span> <input type="text" name="period" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">affiliate_id </span> <input type="text" name="affiliate_id" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Renew" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
