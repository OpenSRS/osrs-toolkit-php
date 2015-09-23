<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\Authenticate;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

    $callArray = array(
        'token' => $_POST['token'],
        'session_token_duration' => $_POST['session_token_duration'],
        'fetch_extra_info' => $_POST['fetch_extra_info'] ? true : false,
        'generate_session_token' => $_POST['generate_session_token'] ? true : false,
    );

    $callArray = array_filter($callArray);

    // Open SRS Call -> Result
    $response = Authenticate::call($callArray);

    // Print out the results
    echo(' In: '.json_encode($callArray).'<br>');
    echo('Out: '.$response);
} else {
    ?>

<?php include('header.inc') ?>
<div class="container">
<h3>authenticate</h3>
<form action="" method="post" class="form-horizontal" >
	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Fetch extra info</label>
	    <div class="controls"><input type="checkbox" name="fetch_extra_info" value="true"></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Generate session token</label>
	    <div class="controls"><input type="checkbox" name="generate_session_token" value="true"></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Token </label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Session token duration </label>
	    <div class="controls"><input type="text" name="session_token_duration" value="" ></div>
	</div>

	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
