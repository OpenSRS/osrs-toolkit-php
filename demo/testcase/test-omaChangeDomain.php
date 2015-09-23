<?php 

require __DIR__.'/../../vendor/autoload.php';

use opensrs\OMA\ChangeDomain;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once dirname(__FILE__).'/../../opensrs/openSRS_loader.php';

    // Put the data to the Formatted array
    $callArray = array(
        'domain' => $_POST['domain'],
        'attributes' => array(
            'timezone' => $_POST['timezone'],
            'language' => $_POST['language'],
            'filtermx' => $_POST['filtermx'],
            'spam_tag' => $_POST['spam_tag'],
            'spam_folder' => $_POST['spam_folder'],
            'spam_level' => $_POST['spam_level'],
        ),
    );
    if (!empty($_POST['token'])) {
        $callArray['token'] = $_POST['token'];
    }

    // Open SRS Call -> Result
    $response = ChangeDomain::call(array_filter_recursive($callArray));

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
<h3>change_domain</h3>
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

	<h4>Optional</h4>
	<div class="control-group">
	    <label class="control-label">Time Zone </label>
	    <div class="controls"><input type="text" name="timezone" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Language </label>
	    <div class="controls"><input type="text" name="language" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Filter MX </label>
	    <div class="controls"><input type="text" name="filtermx" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Spam Tag </label>
	    <div class="controls"><input type="text" name="spam_tag" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Spam Folder </label>
	    <div class="controls"><input type="text" name="spam_folder" value="" ></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Spam Level </label>
	    <div class="controls"><input type="text" name="spam_level" value="" ></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
