<?php 

if (isset($_POST['function'])) {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

    // Form data capture
    $formFormat = $_POST['format'];

    // Put the data to the Formatted array
    $callstring = '';
    $callArray = array(
        'func' => $_POST['function'],
        'data' => array(
            'admin_username' => $_POST['admin_username'],
            'admin_password' => $_POST['admin_password'],
            'admin_domain' => $_POST['admin_domain'],
            'domain' => $_POST['domain'],
            'mailbox' => $_POST['mailbox'],
            'state' => $_POST['state'],
        ),
    );

    if ($formFormat == 'json') {
        $callstring = json_encode($callArray);
    }
    if ($formFormat == 'yaml') {
        $callstring = Spyc::YAMLDump($callArray);
    }

    // Open SRS Call -> Result
    $osrsHandler = processOpenSRS($formFormat, $callstring);

    // Print out the results
    echo(' In: '.$callstring.'<br>');
    echo('Out: '.$osrsHandler->resultFormatted);
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
<form action="test-mailSetDomainAdmin.php" method="post" class="form-horizontal" >
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="mailSetDomainAdmin">

<h4>Authentication</h4>
  
<div class="control-group">
    <label class="control-label">Admin Username </label>
    <div class="controls"><input type="text" name="admin_username" value=""></div>

</div>
<div class="control-group">
    <label class="control-label">Admin Password </label>
    <div class="controls"><input type="text" name="admin_password" value="" ></div>
</div>
<div class="control-group">
    <label class="control-label">Admin Domain </label>
    <div class="controls"><input type="text" name="admin_domain" value="" ></div>
</div>

<h4>Required</h4>

<div class="control-group">
    <label class="control-label">Domain </label>
    <div class="controls"><input type="text" name="domain" value=""></div>
</div>
<div class="control-group">
    <label class="control-label">Mailbox </label>
    <div class="controls"><input type="text" name="mailbox" value="" ></div>
</div>
<div class="control-group">
    <label class="control-label">State </label>
    <div class="controls"><input type="text" name="state" value="" ></div>
</div>

	<input value="Set Domain Admin" type="submit">
</form>
</div>
</body>
</html>

<?php 
}
?>
