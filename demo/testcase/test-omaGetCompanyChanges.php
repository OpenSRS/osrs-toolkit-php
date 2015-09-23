<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\GetCompanyChanges;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../../opensrs/openSRS_loader.php';

    // Put the data to the Formatted array
    $callArray = array(
        'company' => $_POST['company'],
        'range' => array(
            'first' => $_POST['first'],
            'limit' => $_POST['limit'],
        ),
    );

    if (!empty($_POST['token'])) {
        $callArray['token'] = $_POST['token'];
    }
    // Open SRS Call -> Result
    $response = GetCompanyChanges::call(array_filter_recursive($callArray));

    // Print out the results
    echo(' In: '.json_encode($callArray).'<br>');
    echo('Out: '.$response);
} else {
    // Format
    if (isset($_GET['format'])) {
        $tf = $_GET['format'];
    } else {
        $tf = 'json';
    }
    ?>

<?php include('header.inc') ?>
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
