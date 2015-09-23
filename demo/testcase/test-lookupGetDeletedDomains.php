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
            'owner_email' => $_POST['owner_email'],
            'admin_email' => $_POST['admin_email'],
            'billing_email' => $_POST['billing_email'],
            'tech_email' => $_POST['tech_email'],
            'del_from' => $_POST['del_from'],
            'del_to' => $_POST['del_to'],
            'exp_from' => $_POST['exp_from'],
            'exp_to' => $_POST['exp_to'],
            'page' => $_POST['page'],
            'limit' => $_POST['limit'],
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

<form action="test-lookupGetDeletedDomains.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="lookupGetDeletedDomains">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">owner_email </span> <input type="text" name="owner_email" value="*" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">admin_email </span> <input type="text" name="admin_email" value="*" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">billing_email </span> <input type="text" name="billing_email" value="*" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">tech_email </span> <input type="text" name="tech_email" value="*" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">del_from </span> <input type="text" name="del_from" value="2000-01-01" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">del_to </span> <input type="text" name="del_to" value="2011-12-31" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">exp_from </span> <input type="text" name="exp_from" value="2007-01-01" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">exp_to </span> <input type="text" name="exp_to" value="2011-12-31" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">page </span> <input type="text" name="page" value="1" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">limit </span> <input type="text" name="limit" value="100" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Get Deleted Domains" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
