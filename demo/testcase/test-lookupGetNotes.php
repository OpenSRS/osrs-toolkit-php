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
            'type' => $_POST['type'],
            'page' => $_POST['page'],
            'limit' => $_POST['limit'],
            'order_id' => $_POST['order_id'],
            'transfer_id' => $_POST['transfer_id'],
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

<form action="test-lookupGetNotes.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="lookupGetNotes">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">type </span> <input type="text" name="type" value="domain" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">page </span> <input type="text" name="page" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">limit </span> <input type="text" name="limit" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">order_id </span> <input type="text" name="order_id" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">transfer_id </span> <input type="text" name="transfer_id" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Get Notes" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
