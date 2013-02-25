
function makeThatCall (userValEnt, tldStr, dest){
	$.ajax({
		url: 'demo5p.php',
		data: 'format=json&function=lookupDomain&domain='+ userValEnt +'&tld='+ tldStr,			// POST variables
		type: 'POST',
		success: function (htmlResult) {
			$('div#r'+ dest).html(htmlResult);
		}
	});
}



$(function() {
	// Init setup 

	// key binding
	$('#domain').bind('keypress', function(e) {
		// key - Enter
		if(e.keyCode==13){
			
			var tldStr = "";
			var userValEnt = $("input#domain").val();
			if (userValEnt == ""){
				// $("input#domain").val("Please type something here.");
				// empty field check
			} else {
				// Tucows blast all TLD requests are sent to to verification
				
				// Load the values to page
				for (i=0; i<popularFixed.length; i++){
					$('div#r'+ popularFixed[i]).html("<img src='images/smalloaderb.gif' />");
					
					tldStr = $('span#d'+ popularFixed[i]).html();
					makeThatCall (userValEnt, tldStr, popularFixed[i]);
				}
				
				// Load the rest after
				for (i=0; i<domainsFixed.length; i++){
					$('div#r'+ domainsFixed[i]).html("<img src='images/smalloaderb.gif' />");
					
					tldStr = $('span#d'+ domainsFixed[i]).html();
					makeThatCall (userValEnt, tldStr, domainsFixed[i]);
				}
			}
		}
	});

	// Typing and page propagation
	$('#domain').keyup(function () {
		var userVal = $("input#domain").val();
		var t = this;

		// Remove spaces some strings - Add some more here or make it a bit smarter
		userVal = userVal.split(' ').join('')
		userVal = userVal.split('=').join('')
		userVal = userVal.split(',').join('')
		userVal = userVal.split('.').join('')
		userVal = userVal.split('/').join('')
		userVal = userVal.split('?').join('')
		userVal = userVal.split('"').join('')
		userVal = userVal.split('\'').join('')
		$("input#domain").val(userVal);
		
		// Load the values to page
		for (i=0; i<popularFixed.length; i++){
			$('span#f'+ popularFixed[i]).html(userVal);
		}
		for (i=0; i<domainsFixed.length; i++){
			$('span#f'+ domainsFixed[i]).html(userVal);
		}
		
	});	

});
