<?
$callArray = array (
	"func" => "premiumDomain",
	//"func" => "allinone",
        //"func" => "premiumDomain",

        "data" => array (
                "domain" => "hockey.com",
		// These are optional
                "selected" => ".com;.net;.org",
                "alldomains" => ".com;.net;.org" 
        )
);

require_once ("../opensrs/openSRS_loader.php");

//JSON
$callstring = json_encode($callArray);
$osrsHandler = processOpenSRS ("json", $callstring);


//YAML
//$callstring = Spyc::YAMLDump($callArray);
//$osrsHandler = processOpenSRS ("yaml", $callstring);

//$callstring = XML($callArray);
//$osrsHandler = processOpenSRS ("xml", $callstring);

echo (" In: ". $callstring ."<br>");
//echo ("Out Result Full Raw: ". $osrsHandler->resultFullRaw ."<br>");
//echo ("Out Results Formatted: ". $osrsHandler->resultFormated ."<br>");

//Array
$variable = var_dump($osrsHandler->resultRaw, true);
$variable = str_replace ("\n", "<br>\n",  $variable);
echo ("Out Results Formatted: ". $variable);


?>
