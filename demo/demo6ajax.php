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
									<table>
									  <tr>
									  <td><input id="firstname" class="defaultText" name="firstname" title="First Name" value="" type="text" /></td>
									  <td><input id="lastname" class="defaultText" name="lastname" title="Last Name" value="" type="text" /></td>
									  <td><input type="image" name="btnSearch" id="btnSearch" src="images/button_form_search_off.gif" alt="Search" class="searchBtn" /></td>
										</tr>
									</table>
							</div></div></td>
						</tr>
					</table>



					<!-- page content -->

					<div id="content">
						
					<div id="result"></div>
				
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
		
		
				<script type="text/javascript">

				$.ajaxSetup ({  
				cache: false  
					});  
				var ajax_load = "<img src='images/smalloaderb.gif' alt='loading...' /> Loading...";  

				var loadUrl = "demo6p.php";  

				$("#btnSearch").click(function(){  
					$("#result")  
					.html(ajax_load)  
						.load(loadUrl, {function: "persNameSuggest", firstname: $("input#firstname").val(), lastname: $("input#lastname").val() });  
					});

					</script>
		
		
	</body>

	</html>
