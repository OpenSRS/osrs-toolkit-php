<?php

require __DIR__.'/../../vendor/autoload.php';

use opensrs\Request;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // require_once dirname(__FILE__) . "/../../opensrs/spyc.php";

    // Form data capture - ONLY FOR TESTING PURPOSE!!!
    $formSelectedDomainArray = array();
    $allDomainArray = array('.co.uk','.me','.org','.asia','.org.uk','.net','.tel','.com','.mobi','.biz','.info','.ca');
    $formFormat = $_POST['format'];
    $formFunction = $_POST['function'];
    $formSearchWord = $_POST['domain'];

    if (isset($_POST['tld'])) {
        $tld = $_POST['tld'];
        $size = count($tld);
        for ($i = 0; $i < $size; ++$i) {
            array_push($formSelectedDomainArray, $tld[$i]);
        }
    }

    // Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
    $callstring = '';
    $callArray = array(
        'func' => $formFunction,
        'data' => array(
            'domain' => $formSearchWord,
            'selected' => implode(';', $formSelectedDomainArray),
            'alldomains' => implode(';', $allDomainArray),
        ),
    );

    if ($formFormat == 'json') {
        $callstring = json_encode($callArray);
    }
    if ($formFormat == 'yaml') {
        $callstring = Spyc::YAMLDump($callArray);
    }

    try {
        $request = new Request();
        $osrsHandler = $request->process('json', json_encode($callArray));

        // var_dump($osrsHandler->resultRaw);
        echo $osrsHandler->resultFormatted;
    } catch (\opensrs\Exception $e) {
        var_dump($e->getMessage());
    }

    // Open SRS Call -> Result
    // require_once dirname(__FILE__) . "/../..//opensrs/openSRS_loader.php";
    // $osrsHandler = processOpenSRS ($formFormat, $callstring);
    //
    //
    // // Print out the results
    // echo (" In: ". $callstring ."<br>");
    // echo ("Out: ". $osrsHandler->resultFormatted);
    //
    //
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
<form action="" method="post" class="form-horizontal">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="fastDomainLookup">
	
	<div class="row">
		<div class="span12">	
			<div class="control-group">
	    		<label class="control-label">Fast Lookup Domain </label>
	    		<div class="controls"><input type="text" name="domain" value=""></div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="span4">	
			<div class="control-group">	
				<div class="controls"><label class="checkbox">.com<input type="checkbox" name="tld[]" value=".com"></label></div>
				<div class="controls"><label class="checkbox">.net<input type="checkbox" name="tld[]" value=".net"></label></div>
	    		<div class="controls"><label class="checkbox">.org<input type="checkbox" name="tld[]" value=".org"></label></div>
	    		<div class="controls"><label class="checkbox">.info<input type="checkbox" name="tld[]" value=".info"></label></div>
	    		<div class="controls"><label class="checkbox">.co.uk<input type="checkbox" name="tld[]" value=".co.uk"></label></div>
	    		<div class="controls"><label class="checkbox">.me<input type="checkbox" name="tld[]" value=".me"></label></div>
			</div>
		</div>
		<div class="span4">	
			<div class="control-group">	
				<div class="controls"><label class="checkbox">.asia<input type="checkbox" name="tld[]" value=".asia"></label></div>
	    		<div class="controls"><label class="checkbox">..org.uk<input type="checkbox" name="tld[]" value=".org.uk"></label></div>
	    		<div class="controls"><label class="checkbox">.tel<input type="checkbox" name="tld[]" value=".tel"></label></div>
	    		<div class="controls"><label class="checkbox">.mobi<input type="checkbox" name="tld[]" value=".mobi"></label></div>
	    		<div class="controls"><label class="checkbox">.ca<input type="checkbox" name="tld[]" value=".ca"></label></div>
			</div>
		</div>
	</div>

	<input value="Check" class="btn" type="submit">
</form>

</body>
</html>



<?php

}

?>
