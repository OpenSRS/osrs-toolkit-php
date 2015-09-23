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
            'mailbox_type' => $_POST['mailbox_type'],
            'password' => $_POST['password'],
            'disable_forward_email' => $_POST['disable_forward_email'],
            'forward_email' => $_POST['forward_email'],
            'type' => $_POST['type'],
            'name' => $_POST['name'],
            'content' => $_POST['content'],
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

<form action="test-persUpdate.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="persUpdate">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">mailbox_type </span> <input type="text" name="mailbox_type" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">password </span> <input type="text" name="password" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">disable_forward_email </span> <input type="text" name="disable_forward_email" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">forward_email </span> <input type="text" name="forward_email" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">type </span> <input type="text" name="type" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">name </span> <input type="text" name="name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">content </span> <input type="text" name="content" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Personal Update" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
