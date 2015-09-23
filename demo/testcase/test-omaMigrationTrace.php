<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\MigrationTrace;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../../opensrs/openSRS_loader.php';

    // Put the data to the Formatted array
    $callArray = array(
        'job' => $_POST['job'],
        'user' => $_POST['user'],
    );

    if (!empty($_POST['token'])) {
        $callArray['token'] = $_POST['token'];
    }
    $callArray = array_filter($callArray);

    // Open SRS Call -> Result
    $response = MigrationTrace::call($callArray);

    // Print out the results
    echo(' In: '.json_encode($callArray).'<br>');
    echo('Out: '.$response);
} else {
    ?>

<?php include('header.inc') ?>
<div class="container">

<h3>migration_jobs</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h3>Required</h3>
	<div class="control-group">
	    <label class="control-label">Job </label>
	    <div class="controls"><input type="text" name="job" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">User </label>
	    <div class="controls"><input type="text" name="user" value=""></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
