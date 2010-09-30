// Creates a simple user message. 
// Requires message.php
(function( $ )
{
	$.fn.MESSAGE = function(data) 
	{  		
		t = new Date().getTime();
		div = $('#message');
		// if message div doesn't exist, create it			
		if (div.length == 0)
		{		
			// if message div doesn't exist, create it
			$('#scene').append('<div id="message"></div>');
			div = $('#message');
		}

		// add message to message div
		div.html(data.message);
		//div.append('<p id="'+t+'">'+data.message+'</p>');
		
		// get wait time
		if (data.wait_time)
		{
			// if we specified a wait time use that
			wait_time = data.wait_time; 
		}
		else
		{		
			// otherwise wait 5 seconds
			wait_time = 5000;
		}
		// clear message after waiting			
		setTimeout(function(){div.html('');},wait_time);
		//setTimeout(function(){$('#'+t).remove();},wait_time);
				
	};
})( jQuery );
