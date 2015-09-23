<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\GenerateToken;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../../opensrs/openSRS_loader.php';

    // Put the data to the Formatted array
    $callArray = array(
        'user' => $_POST['user'],
        'reason' => $_POST['reason'],
        'attributes' => array(
            'token' => $_POST['token'],
            'duration' => $_POST['duration'],
            'type' => $_POST['type'], //sso or session or oma 
            'oma' => $_POST['oma'] ? true : false,
        ),
    );

    // Open SRS Call -> Result
    $response = GenerateToken::call($callArray);

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
<h3>generate_token</h3>
<form action="" method="post" class="form-horizontal" >
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">User </label>
	    <div class="controls"><input type="text" name="user" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Reason </label>
	    <div class="controls"><input type="text" name="reason" value=""></div>
	</div>

	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Token </label>
	    <div class="controls"><input type="text" name="token" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Duration </label>
	    <div class="controls"><input type="text" name="duration" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Type </label>
	    <div class="controls"><input type="text" name="type" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">OMA </label>
	    <div class="controls"><input type="checkbox" name="oma" value="true"></div>
	</div>

	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
