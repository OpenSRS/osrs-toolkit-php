<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	// Put the data to the Formatted array
	$callArray = array(
		"user" => $_POST["user"],
		"id" => $_POST["id"],
		"folder" => $_POST["folder"]
	);

	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	// Open SRS Call -> Result
	require_once(__DIR__ . "/../openSRS_LoaderWrapper.php");
	$response = Reindex::call($callArray);

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
<h3>reindex</h3>
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
	<div class="control-group">
	    <label class="control-label">ID </label>
	    <div class="controls"><input type="text" name="id" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Folder </label>
	    <div class="controls"><input type="text" name="folder" value=""></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>

</body>
</html>

<?php
}
?>
