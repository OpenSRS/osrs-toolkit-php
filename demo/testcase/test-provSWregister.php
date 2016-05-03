<?php 

use opensrs\Request;

error_reporting(-1);

if (isset($_POST['function'])) {
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
        'cedinfo' => array(
            'contact_type' => $_POST['contact_type'],
            'id_number' => $_POST['id_number'],
            'id_type' => $_POST['id_type'],
            'id_type_info' => $_POST['id_type_info'],
            'legal_entity_type' => $_POST['legal_entity_type'],
            'legal_entity_type_info' => $_POST['legal_entity_type_info'],
            'locality_city' => $_POST['locality_city'],
            'locality_country' => $_POST['locality_country'],
            'locality_state_prov' => $_POST['locality_state_prov'],
            ),
        'nexus' => array(
            'app_purpose' => $_POST['app_purpose'],
            'category' => $_POST['category'],
            'validator' => $_POST['validator'],
            ),
        'it_registrant_info' => array(
            'nationality_code' => $_POST['nationality_code'],
            'reg_code' => $_POST['reg_code'],
            'entity_type' => $_POST['entity_type'],
            ),

        'au_registrant_info' => array(
            'registrant_name' => $_POST['registrant_name'],
            'registrant_id' => $_POST['registrant_id'],
            'registrant_id_type' => $_POST['registrant_id_type'],
            'eligibility_type' => $_POST['eligibility_type'],
            'eligibility_id' => $_POST['eligibility_id'],
            'eligibility_id_type' => $_POST['eligibility_id_type'],
            'eligibility_name' => $_POST['eligibility_name'],

            ),

        'professional_data' => array(
            'authority' => $_POST['authority'],
            'authority_website' => $_POST['authority_website'],
            'license_number' => $_POST['license_number'],
            'profession' => $_POST['profession'],
            ),

        'br_registrant_info' => array(
            'br_register_number' => $_POST['br_register_number'],
            ),

        'data' => array(
            'affiliate_id' => $_POST['affiliate_id'],
            'auto_renew' => $_POST['auto_renew'],
            'ca_link_domain' => $_POST['ca_link_domain'],
            'change_contact' => $_POST['change_contact'],
            'custom_nameservers' => $_POST['custom_nameservers'],
            'custom_tech_contact' => $_POST['custom_tech_contact'],
            'custom_transfer_nameservers' => $_POST['custom_transfer_nameservers'],
            'cwa' => $_POST['cwa'],
            'dns_template' => $_POST['dns_template'],
            'domain' => $_POST['domain'],
            'domain_description' => $_POST['domain_description'],
            'encoding_type' => $_POST['encoding_type'],
            'eu_country' => $_POST['eu_country'],
            'f_lock_domain' => $_POST['f_lock_domain'],
            'f_parkp' => $_POST['f_parkp'],
            'f_whois_privacy' => $_POST['f_whois_privacy'],
            'forwarding_email' => $_POST['forwarding_email'],
            'handle' => $_POST['handle'],
            'isa_trademark' => $_POST['isa_trademark'],
            'lang' => $_POST['lang'],
            'lang_pref' => $_POST['lang_pref'],
            'legal_type' => $_POST['legal_type'],
            'link_domains' => $_POST['link_domains'],
            'master_order_id' => $_POST['master_order_id'],
            'name1' => $_POST['name1'],
            'name2' => $_POST['name2'],
            'name3' => $_POST['name3'],
            'name4' => $_POST['name4'],
            'name5' => $_POST['name5'],
            'owner_confirm_address' => $_POST['owner_confirm_address'],
            'period' => $_POST['period'],
            'premium_price_to_verify' => $_POST['premium_price_to_verify'],
            'rant_agrees' => $_POST['rant_agrees'],
            'rant_no' => $_POST['rant_no'],
            'reg_domain' => $_POST['reg_domain'],
            'reg_password' => $_POST['reg_password'],
            'reg_type' => $_POST['reg_type'],
            'reg_username' => $_POST['reg_username'],
            'sortorder1' => $_POST['sortorder1'],
            'sortorder2' => $_POST['sortorder2'],
            'sortorder3' => $_POST['sortorder3'],
            'sortorder4' => $_POST['sortorder4'],
            'sortorder5' => $_POST['sortorder5'],
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
require_once dirname(__FILE__).'/../../vendor/autoload.php';

// $osrsHandler = processOpenSRS ($formFormat, $callstring);

$request = new Request();
    $osrsHandler = $request->process('array', $callArray);

// Print out the results
echo('{"in":'.$callstring.'},');
    echo('{"out":'.json_encode($osrsHandler->resultRaw).'}');
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


		<form action="test-provSWregister.php" method="post">
			<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
			<input type="hidden" name="function" value="provSWregister">

			<table cellpadding="0" cellspacing="20" border="0" width="100%">
				<tr class="searchBox">
					<td class="searchBoxText" width="100%">
						<span class="headLine">Register new domain</span><br>
					</td>
				</tr>
				<tr>
					<td>
						<b>Personal info</b><br>
						first_name: <input type="text" name="first_name" value="John"><br>
						last_name: <input type="text" name="last_name" value="Smith"><br>
						org_name: <input type="text" name="org_name" value="Tucows"><br>
						address1: <input type="text" name="address1" value="96 Mowat Avenue"><br>
						address2: <input type="text" name="address2" value=""><br>
						address3: <input type="text" name="address3" value=""><br>
						city: <input type="text" name="city" value="Toronto"><br>
						state: <input type="text" name="state" value="ON"><br>
						postal_code: <input type="text" name="postal_code" value="M6K 3M1"><br>
						country: <input type="text" name="country" value="CA"><br>
						phone: <input type="text" name="phone" value="+1.4165350123"><br>
						fax: <input type="text" name="fax" value=""><br>
						email: <input type="text" name="email" value="phptoolkit@tucows.com"><br>
						url: <input type="text" name="url" value="http://www.tucows.com"><br>
						lang_pref: <input type="text" name="lang_pref" value="EN">
					</td>
				</tr>
				<tr>
					<td>
						<b>Required at all time</b><br>

						<?php echo('domain: <input type="text" name="domain" value="phptest'.time().'.com"><br>');
    ?>
						period: <input type="text" name="period" value="1">year(s)<br>
						reg_username: <input type="text" name="reg_username" value="phptest"><br>
						reg_password: <input type="text" name="reg_password" value="abc123"><br>
						reg_type: <input type="text" name="reg_type" value="new"><br>
						custom_tech_contact: <input type="text" name="custom_tech_contact" value="1"><br>
						custom_nameservers: <input type="text" name="custom_nameservers" value="1"><br>
					</td>
				</tr>
				<tr>
					<td>
						<b>Common optional</b><br>
						affiliate_id: <input type="text" name="affiliate_id" value="">Required on renewal order Leave blank for no affiliate<br>
						auto_renew: <input type="text" name="auto_renew" value="0"><br>
						change_contact: <input type="text" name="change_contact" value=""><br>
						reg_domain: <input type="text" name="reg_domain" value=""><br>
						f_parkp: <input type="text" name="f_parkp" value="Y"><br>
						f_whois_privacy: <input type="text" name="f_whois_privacy" value="1"><br>
						f_lock_domain: <input type="text" name="f_lock_domain" value="1"><br>
						link_domains: <input type="text" name="link_domains" value="0"><br>
						master_order_id: <input type="text" name="master_order_id" value=""><br>
						encoding_type: <input type="text" name="encoding_type" value=""><br>
						dns_template: <input type="text" name="dns_template" value=""><br>
						handle: <input type="text" name="handle" value=""><br>
						custom_transfer_nameservers: <input type="text" name="custom_transfer_nameservers" value=""><br>
						premium_price_to_verify: <input type="text" name="premium_price_to_verify" value=""><br>
						nameserver_list >>  <br>
						&nbsp; &nbsp;custom_nameserver: <input type="text" name="name1" value="ns1.systemdns.com"> <input type="text" name="sortorder1" value="1"> <br>
						&nbsp; &nbsp;custom_nameserver: <input type="text" name="name2" value="ns2.systemdns.com"> <input type="text" name="sortorder2" value="2"> <br>
						&nbsp; &nbsp;custom_nameserver: <input type="text" name="name3" value=""> <input type="text" name="sortorder3" value=""> <br>
						&nbsp; &nbsp;custom_nameserver: <input type="text" name="name4" value=""> <input type="text" name="sortorder4" value=""> <br>
						&nbsp; &nbsp;custom_nameserver: <input type="text" name="name5" value=""> <input type="text" name="sortorder5" value=""> <br>
					</td>
				</tr>
				<tr>
					<td>
						<b>.Asia</b><br />
						tld_data >> ced_info >> <br />
						&nbsp; &nbsp;contact_type: <input type="text" name="contact_type" value="owner"><br>
						&nbsp; &nbsp;id_number: <input type="text" name="id_number" value="Pasport number"><br>
						&nbsp; &nbsp;id_type: <input type="text" name="id_type" value="passport"><br>
						&nbsp; &nbsp;id_type_info: <input type="text" name="id_type_info" value=""> required only for id_type = other<br>
						&nbsp; &nbsp;legal_entity_type: <input type="text" name="legal_entity_type" value="naturalPerson"><br>
						&nbsp; &nbsp;legal_entity_type_info: <input type="text" name="legal_entity_type_info" value="">required only for legal_entity_type = other<br>
						&nbsp; &nbsp;locality_city: <input type="text" name="locality_city" value=""> - Optional<br>
						&nbsp; &nbsp;locality_country: <input type="text" name="locality_country" value=""><br>
						&nbsp; &nbsp;locality_state_prov: <input type="text" name="locality_state_prov" value=""> - Optional<br>

					</td>
				</tr>
				<tr>
					<td>
						<b>.EU / .BE / .DE</b><br />
						&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.EU | country: <input type="text" name="eu_country" value="gb"><br>
						&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;.BE | .EU | lang: <input type="text" name="lang" value="en"><br>
						.DE | .BE | .EU | owner_confirm_address: <input type="text" name="owner_confirm_address" value=""><br>
					</td>
				</tr>	
				<tr>
					<td>
						<b>.CA</b><br />
						ca_link_domain: <input type="text" name="ca_link_domain" value=""> - Optional<br>
						cwa: <input type="text" name="cwa" value=""> - Optional<br>
						domain_description: <input type="text" name="domain_description" value=""> - Optional<br>
						isa_trademark: <input type="text" name="isa_trademark" value="0"><br>
						lang_pref: <input type="text" name="lang_pref" value="en"><br>
						legal_type: <input type="text" name="legal_type" value="CCT"><br>
						rant_agrees: <input type="text" name="rant_agrees" value=""> - Optional<br>
						rant_no: <input type="text" name="rant_no" value=""> - Optional<br>
					</td>
				</tr>
				<tr>
					<td>
						<b>.IT</b><br />
						tld_data >> it_registrant_info >> <br/>
						reg_code: <input type="text" name="reg_code" value="SGLMRA80A01H501E"><br>
						entity_type: <input type="text" name="entity_type" value="1"><br>
						nationality_code: <input type="text" name="nationality_code" value=""> - Optional<br>
					</td>
				</tr>
				<tr>
					<td>
						<b>.AU</b><br />
						tld_data >> au_registrant_info >> <br/>
						registrant_name: <input type="text" name="registrant_name" value="Registered Company Name Ltd"><br>
						registrant_id_type: <input type="text" name="registrant_id_type" value="ABN"><br>
						registrant_id: <input type="text" name="registrant_id" value="99 999 999 999"> - Required if registrant_id_type = ACN or ABN<br>
						eligibility_type: <input type="text" name="eligibility_type" value="Registered Business"><br>
						eligibility_id: <input type="text" name="eligibility_id" value="99999999"> - Required for .COM.AU and .NET.AU<br> 
						eligibility_id_type: <input type="text" name="eligibility_id_type" value="ACN"> - Required for .COM.AU and .NET.AU<br> 
						eligibility_name: <input type="text" name="eligibility_name" value="Don Marshall CTO"> - Optional<br>
					</td>
				</tr>

				<tr>
					<td>
						<b>.PRO</b><br />
						tld_data >> professional_data >> <br/>
						profession: <input type="text" name="profession" value="Dentist"><br>
						authority: <input type="text" name="authority" value="Canadian Dental Associatio"> - Optional<br>
						authority_website: <input type="text" name="authority_website" value="http://www.cda-adc.ca"> - Optional<br>
						license_number: <input type="text" name="license_number" value="123456789"> - Optional<br>
					</td>
				</tr>

				<tr>
					<td>
						<b>.US</b><br />
						tld_data >> nexus >> <br/>
						&nbsp; &nbsp;app_purpose: <input type="text" name="app_purpose" value=""><br>
						&nbsp; &nbsp;category: <input type="text" name="category" value=""><br>
						&nbsp; &nbsp;validator: <input type="text" name="validator" value="">Required if category = C31 or C32<br>
					</td>
				</tr>
				<tr>
					<td>
						<b>.HU / .NU / .SE</b><br />
						tld_data >> registrant_extra_info >> <br/>
						&nbsp; &nbsp;registrant_type: <input type="text" name="registrant_type" value="">individual or organization<br>
						&nbsp; &nbsp;id_card_number: <input type="text" name="id_card_number" value="">Required if registrant_type = individual<br>
						&nbsp; &nbsp;registrant_vat_id: <input type="text" name="registrant_vat_id" value="">Required if registrant_type != individual<br>
						&nbsp; &nbsp;registration_number: <input type="text" name="registration_number" value="">Required if registrant_type != individual<br>
					</td>
				</tr>
				<tr>
					<td>
						<b>.NAME</b><br />
						tld_data >> <br/>
						&nbsp; &nbsp;forwarding_email: <input type="text" name="forwarding_email" value=""><br>
					</td>
				</tr>
				<tr>
					<td>
						<b>.COM.BR</b><br />
						tld_data >> <br/>
						&nbsp; &nbsp;br_register_number: <input type="text" name="br_register_number" value=""><br>
					</td>
				</tr>
				<tr>
					<td><input value="Register" id="lookupSearch" type="submit"></td>
				</tr>
			</table>
		</form>



	</body>
	</html>



	<?php 
}
?> 
