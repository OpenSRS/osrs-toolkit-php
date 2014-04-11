<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

	// Put the data to the Formatted array
	$callArray = array(
		"user" => $_POST["user"],
		"attributes" => array(
			"folder" => $_POST["folder"],
			"headers" => $_POST["headers"],
			"job" => $_POST["job"]
		)
	);

	if(!empty($_POST["poll"])){
		$callArray["attributes"]["poll"] = $_POST["poll"];
	}

	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	// Open SRS Call -> Result
	require_once(__DIR__ . "/../openSRS_LoaderWrapper.php");
	$response = GetDeletedMessages::call(array_filter_recursive($callArray));

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

<h3>get_deleted_messages</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">User </label>
	    <div class="controls"><input type="text" name="user" value=""></div>
	</div>
	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Folder </label>
	    <div class="controls"><input type="text" name="folder" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Headers </label>
	    <div class="controls"><input type="text" name="headers" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Poll </label>
	    <div class="controls"><input type="checkbox" name="poll" value="true" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Job </label>
	    <div class="controls"><input type="text" name="job" value=""></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>

</body>
</html>

<?php
}
?>
