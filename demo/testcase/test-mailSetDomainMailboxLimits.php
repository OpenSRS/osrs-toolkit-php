<?php

if (isSet($_POST['function'])) {
	require_once dirname(__FILE__) . "/../../opensrs/spyc.php";

	// Form data capture
	$formFormat = $_POST["format"];

	// Put the data to the Formatted array
	$callstring = "";
	$callArray = array (
		"func" => $_POST["function"],
		"data" => array (
			"admin_username" => $_POST["admin_username"],
			"admin_password" => $_POST["admin_password"],
			"admin_domain" => $_POST["admin_domain"],
			"domain" => $_POST["domain"],
			"mailbox" => $_POST["mailbox"],
			"filter_only" => $_POST["filter_only"],
			"alias" => $_POST["alias"],
			"forward_only" => $_POST["forward_only"],
			"mailing_list" => $_POST["mailing_list"]
		)
	);

	if ($formFormat == "json") $callstring = json_encode($callArray);
	if ($formFormat == "yaml") $callstring = Spyc::YAMLDump($callArray);


	// Open SRS Call -> Result
	require_once(__DIR__ . "/../openSRS_LoaderWrapper.php");
	$osrsHandler = processOpenSRS ($formFormat, $callstring);

	// Print out the results
	echo (" In: ". $callstring ."<br>");
	echo ("Out: ". $osrsHandler->resultFormatted);

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

<form action="test-mailSetDomainMailboxLimits.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="mailSetDomainMailboxLimits">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr><td><b>Authentication</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">admin username </span> <input type="text" name="admin_username" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">admin password </span> <input type="text" name="admin_password" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">admin domain </span> <input type="text" name="admin_domain" value="" class="frontBox"></td>
		</tr>
		<tr><td><b>Required</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">domain </span> <input type="text" name="domain" value="" class="frontBox"></td>
		</tr>
		<tr><td><b>Optional</b></td></tr>
		<tr>
			<td width="100%"><span class="headLine">mailbox </span> <input type="text" name="mailbox" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">filter_only </span> <input type="text" name="filter_only" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">alias </span> <input type="text" name="alias" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">forward_only </span> <input type="text" name="forward_only" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">mailing_list</span> <input type="text" name="mailing_list" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Set Domain Mailbox Limits" type="submit"></td>
		</tr>
	</table>
</form>

</body>
</html>

<?php
}
?>
