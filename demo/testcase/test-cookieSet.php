<?php

if (isSet($_POST['function'])) {

	require_once dirname(__FILE__) . "/../../opensrs/spyc.php";


	// Form data capture
	$formFormat = $_POST["format"];
	$formFunction = $_POST["function"];
	$formSearchWord = $_POST["domain"];

	// Put the data to the Formatted array
	$callstring = "";
	$callArray = array (
		"func" => $formFunction,
		"data" => array (
			"reg_username" => $_POST["reg_username"],
			"reg_password" => $_POST["reg_password"],
			"domain" => $_POST["domain"]
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

<form action="test-cookieSet.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf); ?>">
	<input type="hidden" name="function" value="cookieSet">

	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="100%">
				<span class="headLine">Username </span> <input type="text" name="reg_username" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td width="100%">
				<span class="headLine">Password </span> <input type="text" name="reg_password" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td width="100%">
				<span class="headLine">Domain </span> <input type="text" name="domain" id="domain" value="" class="frontBox"><br>
			</td>
		</tr>
		<tr>
			<td><input value="Set Cookie" id="lookupSearch" type="submit"></td>
		</tr>
	</table>
</form>

</body>
</html>

<?php
}
?>
