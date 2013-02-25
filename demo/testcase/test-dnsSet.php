<?php 

if (isSet($_POST['function'])) {
	require_once dirname(__FILE__) . "/../../opensrs/spyc.php";

	// Form data capture
	$formFormat = $_POST["format"];

	// Put the data to the formated array
	$callstring = "";
	$callArray = array (
		"func" => $_POST["function"],
		"data" => array (
			"domain" => $_POST["domain"],
			"dns_template" => $_POST["dns_template"],
			"a_ip_address" => $_POST["a_ip_address"],
			"a_subdomain" => $_POST["a_subdomain"],
			"aaaa_ipv6_address" => $_POST["aaaa_ipv6_address"],
			"aaaa_subdomain" => $_POST["aaaa_subdomain"],
			"cname_hostname" => $_POST["cname_hostname"],
			"cname_subdomain" => $_POST["cname_subdomain"],
			"mx_priority" => $_POST["mx_priority"],
			"mx_subdomain" => $_POST["mx_subdomain"],
			"mx_hostname" => $_POST["mx_hostname"],
			"srv_priority" => $_POST["srv_priority"],
			"srv_weight" => $_POST["srv_weight"],
			"srv_subdomain" => $_POST["srv_subdomain"],
			"srv_hostname" => $_POST["srv_hostname"],
			"srv_port" => $_POST["srv_port"],
			"txt_subdomain" => $_POST["txt_subdomain"],
			"txt_text" => $_POST["txt_text"]
		)
	);
	
	if ($formFormat == "json") $callstring = json_encode($callArray);
	if ($formFormat == "yaml") $callstring = Spyc::YAMLDump($callArray);

	// Open SRS Call -> Result
	require_once dirname(__FILE__) . "/../..//opensrs/openSRS_loader.php";
	$osrsHandler = processOpenSRS ($formFormat, $callstring);

	// Print out the results
	echo (" In: ". $callstring ."<br>");
	echo ("Out: ". $osrsHandler->resultFormated);

} else {
	// Format
	if (isSet($_GET['format'])) {
		$tf = $_GET['format'];
	} else {
		$tf = "json";
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

<form action="test-dnsSet.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="dnsSet">

	<table cellpadding="0" cellspacing="10" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">dns_template </span> <input type="text" name="dns_template" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%">
				<b>A</b> <br/>
				<span class="headLine">a_ip_address </span> <input type="text" name="a_ip_address" value="" class="frontBox"><br />
				<span class="headLine">a_subdomain </span> <input type="text" name="a_subdomain" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>AAAA</b> <br/>
				<span class="headLine">aaaa_ipv6_address </span> <input type="text" name="aaaa_ipv6_address" value="" class="frontBox"><br />
				<span class="headLine">aaaa_subdomain </span> <input type="text" name="aaaa_subdomain" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>CNAME</b> <br/>
				<span class="headLine">cname_hostname </span> <input type="text" name="cname_hostname" value="" class="frontBox"><br />
				<span class="headLine">cname_subdomain </span> <input type="text" name="cname_subdomain" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>MX</b> <br/>
				<span class="headLine">mx_priority </span> <input type="text" name="mx_priority" value="" class="frontBox"><br />
				<span class="headLine">mx_subdomain </span> <input type="text" name="mx_subdomain" value="" class="frontBox"><br />
				<span class="headLine">mx_hostname </span> <input type="text" name="mx_hostname" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>SRV</b> <br/>
				<span class="headLine">srv_priority </span> <input type="text" name="srv_priority" value="" class="frontBox"><br />
				<span class="headLine">srv_weight </span> <input type="text" name="srv_weight" value="" class="frontBox"><br />
				<span class="headLine">srv_subdomain </span> <input type="text" name="srv_subdomain" value="" class="frontBox"><br />
				<span class="headLine">srv_hostname </span> <input type="text" name="srv_hostname" value="" class="frontBox"><br />
				<span class="headLine">srv_port </span> <input type="text" name="srv_port" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td width="100%">
				<b>TXT</b> <br/>
				<span class="headLine">txt_subdomain </span> <input type="text" name="txt_subdomain" value="" class="frontBox"><br />
				<span class="headLine">txt_text </span> <input type="text" name="txt_text" value="" class="frontBox">
			</td>
		</tr>
		<tr>
			<td><input value="Set DNS" type="submit"></td>
		</tr>
	</table>
</form>
	
</body>
</html>

<?php 
}
?>
