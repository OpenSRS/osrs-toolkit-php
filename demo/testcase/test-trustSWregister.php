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
            'title' => $_POST['title'],
            ),
        'data' => array(
            'approver_email' => $_POST['approver_email'],
            'csr' => $_POST['csr'],
            'domain' => $_POST['domain'],
            'handle' => $_POST['handle'],
            'password' => $_POST['password'],
            'product_type' => $_POST['product_type'],
            'reg_type' => $_POST['reg_type'],
            'search_in_seal' => $_POST['search_in_seal'],
            'server_count' => $_POST['server_count'],
            'server_type' => $_POST['server_type'],
            'special_instructions' => $_POST['special_instructions'],
            'trust_seal' => $_POST['trust_seal'],
            'period' => $_POST['period'],
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
echo('{"in":'.$callstring.'},');
    echo('{"out":'.$osrsHandler->resultFormatted.'}');
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
		<form action="test-trustSWregister.php" method="post">
			<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
			<input type="hidden" name="function" value="trustSWregister">

			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="100%"><span class="headLine">reg_type </span> <input type="text" name="reg_type" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">product_type</span> <input type="text" name="product_type" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">handle </span> <input type="text" name="handle" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
				</tr>

				<tr>
					<td width="100%"><span class="headLine">period </span> <input type="text" name="period" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">server_type </span> <input type="text" name="server_type" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">special_instructions </span> <input type="text" name="special_instructions" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">trust_seal </span> <input type="text" name="trust_seal" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">approver_email </span> <input type="text" name="approver_email" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">csr </span><textarea rows="10" name="csr" id="csr" cols="60"></textarea></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">username (SiteLock and TRUSTe only)</span> <input type="text" name="username" value="" class="frontBox"></td>
				</tr>

				<tr>
					<td width="100%"><span class="headLine">password (SiteLock and TRUSTe only)</span> <input type="text" name="password" value="" class="frontBox"></td>
				</tr>

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
						phone: <input type="text" name="phone" value="+1.4165550123x1812"><br>
						fax: <input type="text" name="fax" value="+1.4165550125"><br>
						email: <input type="text" name="email" value="test@tucows.com"><br>
						title: <input type="text" name="title" value="title test"><br>
					</td>
				</tr>
				<tr>
					<td><input value="Submit" type="submit"></td>
				</tr>
			</table>
		</form>

	</body>
	</html>

	<?php 
}
?>
