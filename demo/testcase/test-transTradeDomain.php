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
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'domain' => $_POST['domain'],
            'email' => $_POST['email'],
            'org_name' => $_POST['org_name'],
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

<form action="test-transTradeDomain.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="transTradeDomain">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">first_name </span> <input type="text" name="first_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">last_name </span> <input type="text" name="last_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">email </span> <input type="text" name="email" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">org_name </span> <input type="text" name="org_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Trade Domain" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>