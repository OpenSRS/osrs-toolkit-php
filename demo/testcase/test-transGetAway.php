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
            'domain' => $_POST['domain'],
            'gaining_registrar' => $_POST['gaining_registrar'],
            'limit' => $_POST['limit'],
            'owner_confirm_from' => $_POST['owner_confirm_from'],
            'owner_confirm_ip' => $_POST['owner_confirm_ip'],
            'owner_confirm_to' => $_POST['owner_confirm_to'],
            'owner_request_from' => $_POST['owner_request_from'],
            'owner_request_to' => $_POST['owner_request_to'],
            'page' => $_POST['page'],
            'req_from' => $_POST['req_from'],
            'req_to' => $_POST['req_to'],
            'status' => $_POST['status'],
            'registry_request_date' => $_POST['registry_request_date'],
            'request_address' => $_POST['request_address'],
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

<form action="test-transGetAway.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="transGetAway">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">gaining_registrar </span> <input type="text" name="gaining_registrar" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">limit </span> <input type="text" name="limit" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">owner_confirm_from </span> <input type="text" name="owner_confirm_from" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">owner_confirm_ip </span> <input type="text" name="owner_confirm_ip" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">owner_confirm_to </span> <input type="text" name="owner_confirm_to" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">owner_request_from </span> <input type="text" name="owner_request_from" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">owner_request_to </span> <input type="text" name="owner_request_to" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">page </span> <input type="text" name="page" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">req_from </span> <input type="text" name="req_from" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">req_to </span> <input type="text" name="req_to" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">status </span> <input type="text" name="status" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">registry_request_date </span> <input type="text" name="registry_request_date" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">request_address </span> <input type="text" name="request_address" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Get Away Transfers" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
