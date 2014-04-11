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
			"change_type" => $_POST["change_type"],
			"op_type" => $_POST["op_type"],
			"apply_to_locked_domains" => $_POST["apply_to_locked_domains"],
			"contact_email" => $_POST["contact_email"],
			"change_items" => $_POST["change_items"]
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

<form action="test-bulkTransfer.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="bulkTransfer">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="headLine">change_type </span> <input type="text" name="change_type" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">op_type </span> <input type="text" name="op_type" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">apply_to_locked_domains </span> <input type="text" name="apply_to_locked_domains" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">contact_email </span> <input type="text" name="contact_email" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td width="100%"><span class="headLine">change_items </span> <input type="text" name="change_items" value="" class="frontBox"></td>
		</tr>
		<tr>
			<td><input value="Bulk Transfer" type="submit"></td>
		</tr>
	</table>
</form>

</body>
</html>

<?php
}
?>
