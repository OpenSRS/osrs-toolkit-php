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
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'authdomain' => $_POST['authdomain'],
            'domain' => $_POST['domain'],
            'welcome_text' => $_POST['welcome_text'],
            'welcome_subject' => $_POST['welcome_subject'],
            'from_address' => $_POST['from_address'],
            'from_name' => $_POST['from_name'],
            'charset' => $_POST['charset'],
            'mime_type' => $_POST['mime_type'],
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

<form action="test-mailCreateDomainWelcomeEmail.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="mailCreateDomainWelcomeEmail">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr><td><b>Authentication</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">username </span> <input type="text" name="username" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">password </span> <input type="text" name="password" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">authdomain </span> <input type="text" name="authdomain" value="" class="frontBox"></td>
		</tr>
		<tr><td><b>Required</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
                <tr>
			<td width="100%"><span class="headLine">welcome_text </span> <input type="text" name="welcome_text" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">welcome_subject </span> <input type="text" name="welcome_subject" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">from_address </span> <input type="text" name="from_address" value="" class="frontBox"></td>
		</tr>
                <tr>
			<td width="100%"><span class="headLine">from_name </span> <input type="text" name="from_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">charset </span> <input type="text" name="charset" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">mime_type </span> <input type="text" name="mime_type" value="" class="frontBox"></td>
                </tr>
		<tr>
			<td><input value="Create Domain Welcome Email" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
