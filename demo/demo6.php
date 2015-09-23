<?php 

if (isset($_POST['function'])) {
    require_once '../opensrs/openSRS_loader.php';

    $callstring = '';

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    $searchstring = $firstname.' '.$lastname;

    $callArray = array(
        'func' => $_POST['function'],
        'data' => array('searchstring' => $searchstring),
    );

    $callstring = json_encode($callArray);
    // Open SRS Call -> Result
    $osrsHandler = processOpenSRS('json', $callstring);
    $json_out = $osrsHandler->resultFormatted;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us" >
<head>
	<link rel="stylesheet" href="css/template.css" type="text/css" />
	<link rel="stylesheet" href="css/template-about.css" type="text/css" />

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script language="Javascript" type="text/javascript" src="js/runonload.js"></script>
	<script language="Javascript" type="text/javascript" src="js/democode.js"></script>	

	
	<style media="screen" type="text/css">
	.defaultText { width: 205px; height: 39px; font-size: 20px;}
	.defaultTextActive { color: #a1a1a1; font-style: italic;}
	input.headerboxNameSuggest {
		width: 208px;
		font-size: 20px;
		border: #31564b 1px solid;
		padding: 2px;
	}
	#content p#available {
		font-style: bold;
		font-size: 20px;
		padding: 15px;
	}
	</style>

</head>

<body>

	<div id="tester"></div>
	<a name="up" id="up"></a>

	<div id="center" align="center">
		<div id="backbanner"><div id="wrapper" class="osrs_header_blue">
			<!-- Page header -->
			<table cellpadding="0" cellspacing="0" border="0" width="960">
				<tr>
					<td width="198" rowspan="2" valign="top"><a href=""><img src="images/osrs_header_logo.png" width="198" height="120" border="0" /></a></td>
					<td class="header_layer1">Toolkit Demo</td>
				</tr>
				<tr>
					<td class="header_layer2"></td>
				</tr>
				<tr>
					<td colspan="2" class="header_layer3" valign="top">
						<div class="headerFieldPadding">
							<div class="headerSearchFieldBack">
								<form id="nameSuggest" class="namesuggest"  method="post">
									<input type="hidden" name="function" value="persNameSuggest">
									<table>
									  <tr><td><input class="defaultText" name="firstname" title="First Name" value="" type="text" /></td>
									  <td><input class="defaultText" name="lastname" title="Last Name" value="" type="text" /></td>
									  <td><input type="image" name="btnSearch" id="btnSearch" src="images/button_form_search_off.gif" alt="Search" class="searchBtn" /></td>
										</tr>
									</table>
								</form>
							</div></div></td>
						</tr>
					</table>



					<!-- page content -->

					<div id="content">
						<table width="540px">
						<?php 
                        if (isset($json_out)) {
                            $json_a = json_decode($json_out, true);

                            $counter = 0;
                            foreach ($json_a['suggestion']['items'] as $item) {
                                if ($item['status'] == 'available') {
                                    $domain = preg_replace("/\./", '@', $item[domain], 1);
                                    if ($counter == 0) {
                                        echo '<p id="available"><strong>'.$domain.'</strong> is available.</p>';
                                        echo '<h2>Available Email Addresses</h2>';
                                    }
                                    $temp = ($counter % 2) + 1;
                                    echo '<tr class="listLine'.$temp.'";"><td>'.$domain.'</td><td>'.$item[status].'</td></tr>';
                                    ++$counter;
                                }
                                if ($counter == 20) {
                                    break;
                                }
                            }
                        }
                        ?>
					</table>	
				</div>

				<!-- Page footer -->
				<div id="footer">
					<!-- Left links -->
					<a href="http://www.facebook.com/home.php#/pages/OpenSRS/127798660660?ref=s">OpenSRS is part of </a><a href="http://www.tucowsinc.com/">Tucows</a>
					<span class="separator">|</span> <a href="http://opensrs.com/privacy">Privacy Policy</a>	<span class="separator">|</span> 
					<a href="http://opensrs.com/sitemap.php">Sitemap</a> <span class="separator">|</span>  &copy; 2010
				</div>	

			</div></div>
		</div>
		
		
		<script type="text/javascript">
				<!--
				$(document).ready(function() {
		    	$(".defaultText").focus(function(srcc) {
		    	  if ($(this).val() == $(this)[0].title) {
		    	      $(this).removeClass("defaultTextActive");
		    	      $(this).val("");
		    	  }
		    	});

		    	$(".defaultText").blur(function() {
		        if ($(this).val() == ""){
		            $(this).addClass("defaultTextActive");
		            $(this).val($(this)[0].title);
		        }
		    	});

		    	$(".defaultText").blur();        
				});
				//-->
			</script>
		
	</body>

	</html>
