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
            'cookie' => $_POST['cookie'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'move_all' => $_POST['move_all'],
            'reg_domain' => $_POST['reg_domain'],
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

<form action="test-authChangeOwnership.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="authChangeOwnership">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">Cookie </span> <input type="text" name="cookie" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">Username </span> <input type="text" name="username" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">Password </span> <input type="text" name="password" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">move_all Flag </span> <input type="text" name="move_all" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">reg_domain Flag </span> <input type="text" name="reg_domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Change Owner" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
