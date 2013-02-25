<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	
	// Put the data to the formated array
	$callArray = array(
		"company" => $_POST["company"],
		"bulletin" => $_POST["bulletin"],
		"type" => $_POST["type"],
		"test_email" => $_POST["test_email"]
	);
	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	
	// Open SRS Call -> Result
	require_once dirname(__FILE__) . "/../../opensrs/openSRS_loader.php";
	$response = PostCompanyBulletin::call(array_filter_recursive($callArray));

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
<h3>post_company_bulletin</h3>
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
	    <label class="control-label">Bulletin </label>
	    <div class="controls"><input type="text" name="bulletin" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Type (auto or manual) </label>
	    <div class="controls"><input type="text" name="type" value="" ></div>
	</div>
	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Test Email </label>
	    <div class="controls"><input type="text" name="test_email" value=""></div>
	</div>

	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
