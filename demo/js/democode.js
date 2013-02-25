// democode.js is used by demo5 and demo6 

function makeThatCall (searchString, tldStr){
	$.ajax({
		url: 'demo5p.php',
		data: { "format": "json", "func": "lookupDomain", "domain": searchString, "tld[]": tldStr},
		type: 'POST',
		dataType: 'json',
		success: function (data) {
		  for (i=0; i<data.length; i++){
		    var tld = data[i]['domain'].split('.');
		    var arr = tld.slice(1, tld.length);
		    $('div#r-'+ arr.join("-")).html(data[i]['status']);	
			}
		},
		error: function(data) {	
			$('div#testres').html("POST Reuqest Failed"); 
		},

	});
}

$(function() {

  $('#nameSuggest').bind('submit', function(e){			
		 $("div#tester").html("<img src='images/smalloaderb.gif' />");	    
	});
	
	$('#domain').bind('keypress', function(e) {
		// key - Enter
		if(e.keyCode==13){
			
			var tldStr = Array();			
			var searchString = $("input#domain").val();
			if (searchString == ""){
				// $("input#domain").val("Please type something here.");
				// empty field check
			} else {
				// Tucows blast all TLD requests are sent to to verification
				
				// Load the values to page
				for (i=0; i<popularFixed.length; i++){
					$('div#r'+ popularFixed[i]).html("<img src='images/smalloaderb.gif' />");	
					tldStr.push($('span#d'+ popularFixed[i]).html());
				}
			  makeThatCall(searchString, tldStr);	
			
				// Load the rest after
				var tldStr2 = Array();
				for (i=0; i<domainsFixed.length; i++){
					$('div#r'+ domainsFixed[i]).html("<img src='images/smalloaderb.gif' />");
					tldStr2.push($('span#d'+ domainsFixed[i]).html());
				}
				makeThatCall(searchString, tldStr2);
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
