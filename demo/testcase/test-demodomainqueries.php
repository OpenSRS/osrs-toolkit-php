<?php 

if (isset($_POST['function'])) {
    require_once dirname(__FILE__).'/../..//opensrs/openSRS_loader.php';

// !!!!!!!! ---  Proper form values verification  --- !!!!!!!!!

// Form data capture - ONLY FOR TESTING PURPOSE!!!
$formSelectedDomainArray = array();
    $allDomainArray = array('.co.uk','.org','.asia','.org.uk','.net','.tel','.com','.biz','.info','.ca');
    $formFormat = $_POST['format'];
    $formFunction = $_POST['function'];
    $formSearchWord = $_POST['domain'];

    for ($i = 0; $i <= 50; ++$i) {
        if (isset($_POST['tld_'.$i])) {
            array_push($formSelectedDomainArray, $_POST['tld_'.$i]);
        }
    }

// Put the data to the proper form - ONLY FOR TESTING PURPOSE!!!
$callstring = '';
    $callArray = array(
    'func' => $formFunction,
    'data' => array(
        'domain' => $formSearchWord,
        'selected' => implode(';', $formSelectedDomainArray),
        'defaulttld' => implode(';', $allDomainArray),
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
    $capArray = convertFormatted2array($formFormat, $osrsHandler->resultFormatted);

    $arraLookup = $capArray['lookup'];
    $arraPrem = $capArray['premium'];
    $arraSugg = $capArray['suggestion'];

// Print out the results
// echo (" In: ". $callstring ."<br>");
// echo ("Out: ". $osrsHandler->resultFormatted)
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title></title>
	<meta name="generator" http-equiv="generator" content="Claire Lam" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en"/>
	
	
	<!-- CSS Styles -->
	<style type="text/css">
		.allleft {
			float: left;
			width: 350px;
		}
		.cent {
			float: center;
			margin: 0 auto;
			text-align: center;
		}
	</style>		
</head>
<body>


<form action="test-demodomainqueries.php" method="post">
	<input type="hidden" name="format" value="<?php echo($formFormat);
    ?>">
	<input type="hidden" name="function" value="allinoneDomain">

<center>
	<div><span class="headLine">Lookup / Suggest / Premuim Doamins</span></div>	
	<div><input type="text" name="domain" id="domain" value="<?php echo($formSearchWord);
    ?>" class="frontBox" size="60"> <input value="Check" id="lookupSearch" type="submit"></div>
</center>
</form>

<table cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
		<td>

	<div class="cent">
		<div class="allleft">Current
<?php 
if (count($arraLookup) != 0) {
    echo("	<div><h4>Lookup</h4></div>\n");
    echo('	<div>'.$arraLookup[0]['domain'].' - <b>'.$arraLookup[0]['status']."</b></div>\n");
}
    ?>			
		</div>
		<div class="allleft">With new implementation
	
<?php 
if (count($arraLookup) != 0) {
    echo("	<div><h4>Lookup</h4></div>\n");
    for ($i = 0; $i < count($arraLookup); ++$i) {
        echo('	<div>'.$arraLookup[$i]['domain'].' - <b>'.$arraLookup[$i]['status']."</b></div>\n");
    }
}

    if (count($arraSugg) != 0) {
        echo("	<div><h4>Suggest</h4></div>\n");
        $noRes = (count($arraSugg) > 5) ? 5 : count($arraSugg);
        for ($i = 0; $i < $noRes; ++$i) {
            echo('	<div>'.$arraSugg[$i]['domain'].' - <b>'.$arraSugg[$i]['status']."</b></div>\n");
        }
    }

    if (count($arraPrem) != 0) {
        echo("	<div><h4>Premium</h4></div>\n");
        $noRes = (count($arraPrem) > 5) ? 5 : count($arraPrem);
        for ($i = 0; $i < $noRes; ++$i) {
            echo('	<div>'.$arraPrem[$i]['domain'].' - <b>'.$arraPrem[$i]['status']."</b></div>\n");
        }
    } else {
        echo("	<div><h4>Premium</h4></div>\n");
        echo("	<div>- no results -</div>\n");
    }
    ?>
		</div>
	</div>
		</td>
	</tr>
</table>

</body>
</html>
<?php

} else {
    // Format
    if (isset($_GET['format'])) {
        $tf = $_GET['format'];
    } else {
        $tf = 'json';
    }
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title></title>
	<meta name="generator" http-equiv="generator" content="Claire Lam" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en"/>
</head>
<body>

<form action="test-demodomainqueries.php" method="post">
	<input type="hidden" name="format" value="<?php echo($tf);
    ?>">
	<input type="hidden" name="function" value="allinoneDomain">
	<center>
		<div><span class="headLine">Lookup / Suggest / Premuim Doamins</span></div>	
		<div><input type="text" name="domain" id="domain" value="" class="frontBox" size="60"> <input value="Check" id="lookupSearch" type="submit"></div>
	</center>
</form>
<!--
	<div>
		<div class="fronttld"><input name="tld_1" id="tld_1" value=".co.uk" type="checkbox"> .co.uk</div>
		<div class="fronttld"><input name="tld_2" id="tld_2" value=".ms" type="checkbox"> .ms</div>
		<div class="fronttld"><input name="tld_3" id="tld_3" value=".org" type="checkbox"> .org</div>
		<div class="fronttld"><input name="tld_4" id="tld_4" value=".asia" type="checkbox"> .asia</div>
		<div class="fronttld"><input name="tld_5" id="tld_5" value=".org.uk" type="checkbox"> .org.uk</div>
		<div class="fronttld"><input name="tld_6" id="tld_6" value=".net" type="checkbox"> .net</div>
		<div class="fronttld"><input name="tld_7" id="tld_7" value=".tel" type="checkbox"> .tel</div>
		<div class="fronttld"><input name="tld_8" id="tld_8" value=".com" type="checkbox"> .com</div>
		<div class="fronttld"><input name="tld_9" id="tld_9" value=".mobi" type="checkbox"> .mobi</div>
		<div class="fronttld"><input name="tld_10" id="tld_10" value=".biz" type="checkbox"> .biz</div>
		<div class="fronttld"><input name="tld_11" id="tld_11" value=".info" type="checkbox"> .info</div>
		<div class="fronttld"><input name="tld_12" id="tld_12" value=".ca" type="checkbox"> .ca</div>
	</div>
-->
</body>
</html>
<?php 
}
?> 