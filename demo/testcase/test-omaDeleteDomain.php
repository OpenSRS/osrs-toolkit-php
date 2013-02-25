<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	
	// Put the data to the formated array
	$callArray = array(
		"domain" => $_POST["domain"],
	);
	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	
	// Open SRS Call -> Result
	require_once dirname(__FILE__) . "/../../opensrs/openSRS_loader.php";
	$response = DeleteDomain::call($callArray);

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
<h3>delete_domain</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">Domain </label>
	    <div class="controls"><input type="text" name="domain" value=""></div>
	</div>


	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
