<?php 

if (isset($_POST['function'])) {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

    // Form data capture
    $formFormat = $_POST['format'];

    // Put the data to the Formatted array
    $callstring = '';
    $callArray = array(
        'func' => $_POST['function'],
        'personal' => array(
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'org_name' => $_POST['org_name'],
            'address1' => $_POST['address1'],
            'address2' => $_POST['address2'],
            'address3' => $_POST['address3'],
            'city' => $_POST['city'],
            'state' => $_POST['state'],
            'postal_code' => $_POST['postal_code'],
            'country' => $_POST['country'],
            'phone' => $_POST['phone'],
            'fax' => $_POST['fax'],
            'email' => $_POST['email'],
            'url' => $_POST['url'],
            'lang_pref' => $_POST['lang_pref'],
        ),
        'data' => array(
            'ccp_enabled' => $_POST['ccp_enabled'],
            'low_balance_email' => $_POST['low_balance_email'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'pricing_plan' => $_POST['pricing_plan'],
            'status' => $_POST['status'],
            'system_status_email' => $_POST['system_status_email'],
            'payment_email' => $_POST['payment_email'],
            'payment_email' => $_POST['payment_email'],
            'url' => $_POST['url'],
            'nameservers' => $_POST['nameservers'],
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

<form action="test-subresCreate.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="subresCreate">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td>
				<b>Personal info</b><br>
				first_name: <input type="text" name="first_name" value="Claire"><br>
				last_name: <input type="text" name="last_name" value="Lam"><br>
				org_name: <input type="text" name="org_name" value="Tucows"><br>
				address1: <input type="text" name="address1" value="96 Mowat Avenue"><br>
				address2: <input type="text" name="address2" value=""><br>
				address3: <input type="text" name="address3" value=""><br>
				city: <input type="text" name="city" value="Toronto"><br>
				state: <input type="text" name="state" value="ON"><br>
				postal_code: <input type="text" name="postal_code" value="M6K 3M1"><br>
				country: <input type="text" name="country" value="CA"><br>
				phone: <input type="text" name="phone" value="416-535-0123 x1386"><br>
				fax: <input type="text" name="fax" value=""><br>
				email: <input type="text" name="email" value="clam@tucows.com"><br>
				url: <input type="text" name="url" value="http://www.tucows.com"><br>
				lang_pref: <input type="text" name="lang_pref" value="EN">
			</td>
		</tr>		
		<tr>
			<td>
				<b>Domain info</b><br>
				ccp_enabled: <input type="text" name="ccp_enabled" value="n"><br />
				low_balance_email: <input type="text" name="low_balance_email" value="mbrown@example.com"><br />
				username: <input type="text" name="username" value="clamSubresell"><br />
				password: <input type="text" name="password" value="changeit132456"><br />
				pricing_plan: <input type="text" name="pricing_plan" value="gold"><br />
				status: <input type="text" name="status" value="active"><br />
				system_status_email: <input type="text" name="system_status_email" value="rory@example.com"><br />
				payment_email: <input type="text" name="payment_email" value="tstewart@tucows.com"><br />
				url: <input type="text" name="url" value="testurl.com"><br />
				nameservers: <input type="text" name="nameservers" value="parking1.mdnsservice.com,parking2.mdnsservice.com"> coma separated, no spaces<br />
			</td>
		</tr>
		<tr>
			<td><input value="Create Subreseller" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
