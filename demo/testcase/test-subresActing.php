<?php 

if (isset($_POST['function'])) {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

// !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!

// Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
$formFormat = $_POST['format'];
    $formFunction = $_POST['function'];

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
        'reg_username' => $_POST['reg_username'],
        'reg_password' => $_POST['reg_password'],
        'reg_domain' => $_POST['reg_domain'],
        'affiliate_id' => $_POST['affiliate_id'],
        'auto_renew' => $_POST['auto_renew'],
        'domain' => $_POST['domain'],
        'f_parkp' => $_POST['f_parkp'],
        'f_whois_privacy' => $_POST['f_whois_privacy'],
        'f_lock_domain' => $_POST['f_lock_domain'],
        'period' => $_POST['period'],
        'link_domains' => $_POST['link_domains'],
        'custom_nameservers' => $_POST['custom_nameservers'],
        'name1' => $_POST['name1'],
        'sortorder1' => $_POST['sortorder1'],
        'name2' => $_POST['name2'],
        'sortorder2' => $_POST['sortorder2'],
        'name3' => $_POST['name3'],
        'sortorder3' => $_POST['sortorder3'],
        'name4' => $_POST['name4'],
        'sortorder4' => $_POST['sortorder4'],
        'name5' => $_POST['name5'],
        'sortorder5' => $_POST['sortorder5'],
        'encoding_type' => $_POST['encoding_type'],
        'custom_tech_contact' => $_POST['custom_tech_contact'],
        'as_subreseller' => $_POST['as_subreseller'],
        'bulk_order' => $_POST['bulk_order'],
    ),
);

    if ($formFormat == 'array') {
        $callstring = $callArray;
    }
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


<form action="test-subresActing.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="subresActing">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr class="searchBox">
		<td class="searchBoxText" width="100%">
			<span class="headLine">Register new domain</span><br>
		</td>
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
			reg_username: <input type="text" name="reg_username" value="clam"><br>
			reg_password: <input type="text" name="reg_password" value="abc123"><br>
			reg_domain: <input type="text" name="reg_domain" value=""><br>
			affiliate_id: <input type="text" name="affiliate_id" value="">Recorded on renewal order Leave blank for no affiliate<br>
			auto_renew: <input type="text" name="auto_renew" value="0"><br>
			domain: <input type="text" name="domain" value="tucowstest1000120xx.com"><br>
			
			f_parkp: <input type="text" name="f_parkp" value="Y"><br>
			f_whois_privacy: <input type="text" name="f_whois_privacy" value="1"><br>
			f_lock_domain: <input type="text" name="f_lock_domain" value="1"><br>
			period: <input type="text" name="period" value="1">year(s)<br>
			link_domains: <input type="text" name="link_domains" value="0"><br>
			custom_nameservers: <input type="text" name="custom_nameservers" value="1"><br>
			as_subreseller: <input type="text" name="as_subreseller" value="subrsp"><br>
			bulk_order: <input type="text" name="bulk_order" value="0"><br>
			nameserver_list >>  <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name1" value="ns1.nameserver.com"> <input type="text" name="sortorder1" value="1"> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name2" value="ns2.nameserver.com"> <input type="text" name="sortorder2" value="2"> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name3" value=""> <input type="text" name="sortorder3" value=""> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name4" value=""> <input type="text" name="sortorder4" value=""> <br>
			&nbsp; &nbsp;custom_nameserver: <input type="text" name="name5" value=""> <input type="text" name="sortorder5" value=""> <br>
			encoding_type: <input type="text" name="encoding_type" value=""><br>
			custom_tech_contact: <input type="text" name="custom_tech_contact" value="0"><br>
		</td>
	</tr>
	<tr>
		<td><input value="Register as Subreseller" id="lookupSearch" type="submit"></td>
	</tr>
</table>
</form>


	
</body>
</html>



<?php 
}
?> 