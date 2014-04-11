<?php

if (isSet($_POST['function'])) {
	// ONLY FOR TESTING PURPOSE!!!
	require_once dirname(__FILE__) . "/../../opensrs/spyc.php";

	// Form data capture
	$formFormat = $_POST["format"];

	// Put the data to the Formatted array
	$callstring = "";
	$callArray = array (
		"func" => $_POST["function"],
		"data" => array (
			"exp_from" => $_POST["exp_from"],
			"exp_to" => $_POST["exp_to"],
			"page" => $_POST["page"],
			"limit" => $_POST["limit"]
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

<form action="test-lookupGetDomainsByExpiry.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="lookupGetDomainsByExpiry">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">exp_from </span> <input type="text" name="exp_from" value="2009-12-03" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">exp_to </span> <input type="text" name="exp_to" value="2009-12-25" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">page </span> <input type="text" name="page" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">limit </span> <input type="text" name="limit" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Get Domains By Expiry" type="submit"></td>
		</tr>
	</table>
</form>

</body>
</html>

<?php
}
?>
