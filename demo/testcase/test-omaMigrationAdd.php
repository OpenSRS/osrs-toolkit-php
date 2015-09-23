<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\MigrationAdd;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../../opensrs/openSRS_loader.php';

    // Put the data to the Formatted array
    $callArray = array(
        'job' => $_POST['job'],
        'users' => array(
            array(
                'local' => $_POST['local'],
                'remote' => $_POST['remote'],
                'password' => $_POST['password'],
                'server' => $_POST['server'],
                'method' => $_POST['method'],
            ),
        ),
    );

    if (!empty($_POST['token'])) {
        $callArray['token'] = $_POST['token'];
    }

    if (!empty($_POST['skip'])) {
        $callArray['users'][0]['skip'] = explode(',', $_POST['skip']);
    }
    if (!empty($_POST['translate'])) {
        $folder_arr = explode(',', $_POST['translate']);
        foreach ($folder_arr as $folder => $line) {
            list($key, $value) = explode('=', $line);
            $callArray['users'][0]['translate'][$key] = $value;
        }
    }
    $callArray['users'] = array_filter($callArray['users']);
    $callArray = array_filter($callArray);

    // Open SRS Call -> Result
    $response = MigrationAdd::call($callArray);

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

<h3>migration_add</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">Job </label>
	    <div class="controls"><input type="text" name="job" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Local </label>
	    <div class="controls"><input type="text" name="local" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Remote </label>
	    <div class="controls"><input type="text" name="remote" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Password </label>
	    <div class="controls"><input type="text" name="password" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Server </label>
	    <div class="controls"><input type="text" name="server" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Method </label>
	    <div class="controls"><input type="text" name="method" value="" ></div>
	</div>
	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Skip (comma separated) </label>
	    <div class="controls"><input type="text" name="skip" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Translate </label>
	    <div class="controls"><input type="text" name="translate" value="" ></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
