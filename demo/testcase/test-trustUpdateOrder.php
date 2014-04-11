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
			"order_id" => $_POST["order_id"],
			"approver_email" => $_POST["approver_email"],
			"csr" => $_POST["csr"],
			"product_type" => $_POST["product_type"],
			"reg_type" => $_POST["reg_type"],
			"server_count" => $_POST["server_count"],
			"server_type" => $_POST["server_type"],
			"special_instructions" => $_POST["special_instructions"],
			"period" => $_POST["period"]
		)
	);

	if ($formFormat == "json") $callstring = json_encode($callArray);
	if ($formFormat == "yaml") $callstring = Spyc::YAMLDump($callArray);


	// Open SRS Call -> Result
	require_once(__DIR__ . "/../openSRS_LoaderWrapper.php");
	$osrsHandler = processOpenSRS($formFormat, $callstring);

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
		<form action="test-trustUpdateOrder.php" method="post">
			<input type="hidden" name="format" value="<?php echo($tf); ?>">
			<input type="hidden" name="function" value="trustUpdateOrder">

			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="100%"><span class="headLine">order_id** </span> <input type="text" name="order_id" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">reg_type (Sitelock Only)</span> <input type="text" name="reg_type" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">product_type</span> <input type="text" name="product_type" value="" class="frontBox"></td>
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
					<td width="100%"><span class="headLine">approver_email </span> <input type="text" name="approver_email" value="" class="frontBox"></td>
				</tr>
				<tr>
					<td width="100%"><span class="headLine">csr </span><textarea rows="10" name="csr" id="csr" cols="60"></textarea></td>
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
