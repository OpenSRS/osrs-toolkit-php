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
            'bypass' => $_POST['bypass'],
            'ipaddress' => $_POST['ipaddress'],
            'name' => $_POST['name'],
            'new_name' => $_POST['new_name'],
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

<form action="test-nsModify.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="nsModify">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">cookie </span> <input type="text" name="cookie" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">bypass domain </span> <input type="text" name="bypass" value="" class="frontBox"> <small>In case that your provider allows you to use this. Cookie not required.</small></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">ipaddress </span> <input type="text" name="ipaddress" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">name </span> <input type="text" name="name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">new_name </span> <input type="text" name="new_name" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Modify nameserver" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
