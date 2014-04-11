<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	// Put the data to the Formatted array
	$callArray = array(
		"company" => $_POST["company"],
		"range" => array(
			"first" => $_POST["first"],
			"limit" => $_POST["limit"]
		)
	);

	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	// Open SRS Call -> Result
	require_once(__DIR__ . "/../openSRS_LoaderWrapper.php");
	$response = GetCompanyChanges::call(array_filter_recursive($callArray));

	// Print out the results
	echo (" In: ". json_encode($callArray) ."<br>");
	echo ("Out: ". $response);

} else {
	// Format
	if (isSet($_GET['format'])) {
		$tf = $_GET['format'];
	} else {
		$tf = "json";
	}
?>

<?php include("header.inc") ?>
<div class="container">
<h3>get_company_changes</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">Company </label>
	    <div class="controls"><input type="text" name="company" value=""></div>
	</div>
	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">First </label>
	    <div class="controls"><input type="text" name="first" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Limit </label>
	    <div class="controls"><input type="text" name="limit" value=""></div>
	</div>

	<input class="btn" value="Submit" type="submit">
</form>
</div>

</body>
</html>

<?php
}
?>
