<?php
    $callArray = array(
        //"func" => "suggestDomain",
        //"func" => "allinone",
        'func' => 'lookupDomain',
        'data' => array(
            'domain' => 'example.on.ca',
            // These are optional
            'selected' => '.com;.net',
            'alldomains' => '.com;.net',
        ),
    );

    require_once '../opensrs/openSRS_loader.php';
    $callstring = json_encode($callArray);
    $osrsHandler = processOpenSRS('json', $callstring);

    // $callstring = Spyc::YAMLDump($callArray);
    // $osrsHandler = processOpenSRS ("yaml", $callstring);

    // $callstring = XML($callArray);
    // $osrsHandler = processOpenSRS ("xml", $callstring);

    $serverResult = $osrsHandler->resultFullFormatted;
    $serverResShort = $osrsHandler->resultFormatted;
    $serverResArray = $osrsHandler->resultRaw;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us" >
<head>
	<link rel="stylesheet" href="css/template.css" type="text/css" />
	<link rel="stylesheet" href="css/template-about.css" type="text/css" />
	
    <script language="Javascript" type="text/javascript" src="js/json2.js"></script>
    <script language="Javascript" type="text/javascript" src="js/jquery-1.3.2.js"></script>
    <script language="Javascript" type="text/javascript" src="js/jquery-ui-1.7.2.js"></script>
    <script language="Javascript" type="text/javascript" src="js/runonload.js"></script>
	
	<script type="text/javascript">
		var myJSONObject = <?php  echo($serverResShort); ?>;
		var outHTML = "";

		outHTML += "<table cellpadding=\"10\" cellspacing=\"0\" border=\"1\" width=\"900\" align=\"center\">";
		outHTML += "<tr>";
		outHTML += "	<td colspan=\"2\"><h2>HTML generated from JavaScript / jQuery</h2></td>";
		outHTML += "</tr>";
		for (i=0; i < myJSONObject.length; i ++){
			outHTML += "<tr>";
			outHTML += "<td>"+ myJSONObject[i].domain +"</td>";
			outHTML += "<td>"+ myJSONObject[i].status +"</td>";
			outHTML += "</tr>";
		}
		outHTML += "</table>";

		runOnLoad(function(){
			$('div#mainPageBody').html(outHTML);
		});
	</script>	
</head>

<body>
	<table cellpadding="10" cellspacing="0" border="1" width="900" align="center">
		<tr>
			<td><b>JSON call:</b><br /> <?php echo($callstring);?></td>
		</tr>
		<tr>
			<td><b>JSON response:</b><br /> <?php echo($serverResult);?></td>
		</tr>
		<tr>
			<td><b>Array call:</b><br /> <?php print_r($callArray);?></td>
		</tr>
		<tr>
			<td><b>Array response:</b><br /> <?php print_r($serverResArray);?></td>
		</tr>
	</table>

	<br /> <br />

	<table cellpadding="10" cellspacing="0" border="1" width="900" align="center">
		<tr>
			<td colspan="2"><h2>HTML generated from PHP</h2></td>
		</tr>
<?php 
    for ($i = 0; $i < count($serverResArray); ++$i) {
        ?>		
		<tr>
			<td><?php echo($serverResArray[$i]['domain']);
        ?></td>
			<td><?php echo($serverResArray[$i]['status']);
        ?></td>
		</tr>
<?php 
    }
?>
	</table>

	<br /> <br />

	<div id="mainPageBody"></div>


</body>

</html>