// Creates a simple user message. 
// Requires message.php
(function( $ )
{
	$.fn.MESSAGE = function(data) 
	{  		
		div = $('#message');			
		if (div.length == 0)
		{		
			// if message div doesn't exist, create it
			$('#scene').append('<div id="message">'+data.message+'</div>');
			div = $('#message');
		}
		else
		{
			// otherwise just update it
			div.html(data.message);
		}
		
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
	};
})( jQuery );
