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
            'registrant_ip' => $_POST['registrant_ip'],
            'affiliate_id' => $_POST['affiliate_id'],
            'reg_username' => $_POST['reg_username'],
            'reg_domain' => $_POST['reg_domain'],
            'reg_password' => $_POST['reg_password'],
            'custom_tech_contact' => $_POST['custom_tech_contact'],
            'handle' => $_POST['handle'],
            'domain_list' => $_POST['domain_list'],
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

<form action="test-bulkChange.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="bulkChange">

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
				registrant_ip: <input type="text" name="registrant_ip" value=""><br>
				affiliate_id: <input type="text" name="affiliate_id" value="">Recorded on renewal order Leave blank for no affiliate<br>
				reg_username: <input type="text" name="reg_username" value="clam"><br>
				reg_password: <input type="text" name="reg_password" value="abc123"><br>
				reg_domain: <input type="text" name="reg_domain" value=""><br>
				custom_tech_contact: <input type="text" name="custom_tech_contact" value=""><br>
				handle: <input type="text" name="handle" value=""><br>
				domain_list: <input type="text" name="domain_list" value="">coma separated no spaces
			</td>
		</tr>
		<tr>
			<td><input value="Bulk Change" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
