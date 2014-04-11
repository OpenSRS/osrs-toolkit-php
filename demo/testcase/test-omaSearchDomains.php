<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	// Put the data to the Formatted array
	$callArray = array(
		"criteria" => array(
			"company" => $_POST["company"],
			"match" => $_POST["match"]
		),
		"range" => array(
			"first" => $_POST["first"],
			"limit" => $_POST["limit"]
		),
		"sort" => array(
			"by" => $_POST["by"],
			"direction" => $_POST["direction"]
		)
	);

	if (! empty($_POST["deleted"])) {
		$callArray["criteria"]["deleted"] = true;
	}
	if (! empty($_POST["type"])) {
		$callArray["criteria"]["type"] = explode(",", $_POST["type"]);
	}

	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	// Open SRS Call -> Result
	require_once(__DIR__ . "/../openSRS_LoaderWrapper.php");
	$response = SearchDomains::call(array_filter_recursive($callArray));

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
<h3>search_domains</h3>
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
	<div class="control-group">
	    <label class="control-label">Type </label>
	    <div class="controls"><input type="text" name="type" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Match </label>
	    <div class="controls"><input type="text" name="match" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Deleted </label>
	    <div class="controls"><input type="checkbox" name="deleted" value="true"></div>
	</div>

	<h4>Optional</h4>
	<h5>Range</h5>
	<div class="control-group">
	    <label class="control-label">First </label>
	    <div class="controls"><input type="text" name="first" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Limit </label>
	    <div class="controls"><input type="text" name="limit" value=""></div>
	</div>

	<h5>Sort</h5>
	<div class="control-group">
	    <label class="control-label">By </label>
	    <div class="controls"><input type="text" name="by" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Direction </label>
	    <div class="controls"><input type="text" name="direction" value=""></div>
	</div>


	<input class="btn" value="Submit" type="submit">
</form>
</div>

</body>
</html>

<?php
}
?>
