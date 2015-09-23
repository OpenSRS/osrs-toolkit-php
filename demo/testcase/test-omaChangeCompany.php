<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\ChangeCompany;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../../opensrs/openSRS_loader.php';

    // Put the data to the Formatted array
    $callArray = array(
        'company' => $_POST['user'],
        'attributes' => array(
            'password' => $_POST['password'],
            'spamtag' => $_POST['spamtag'],
            'allow' => explode(',', $_POST['allow']),
            'block' => explode(',', $_POST['block']),
        ),
    );
    if (!empty($_POST['token'])) {
        $callArray['token'] = $_POST['token'];
    }
    // Open SRS Call -> Result
    $response = ChangeCompany::call(array_filter_recursive($callArray));

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

<h3>change_company</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">Company </label>
	    <div class="controls"><input type="text" name="user" value=""></div>
	</div>

	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Password </label>
	    <div class="controls"><input type="text" name="password" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Spam Tag </label>
	    <div class="controls"><input type="text" name="spamtag" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Allow List </label>
	    <div class="controls"><input type="text" name="allow" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Block List </label>
	    <div class="controls"><input type="text" name="block" value="" ></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
