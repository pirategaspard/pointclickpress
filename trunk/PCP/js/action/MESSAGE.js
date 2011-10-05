// Creates a simple user message. 
// Requires message.php
(function( $ )
{
	$.fn.MESSAGE = function(data) 
	{  		
		var t = new Date().getTime();
		var div = $('#message>.container');
		var wait_time = 50000;  // default waittime
		
		// if message div doesn't exist, create it			
		if (div.length == 0)
		{		
			$('#description').before('<p id="message"><span class="container"></span></p>');
			div = $('#message>.container');
		}

		// add message to message div
		div.html('<span class="text" id="'+t+'">'+data.message+'</span>');
		//div.append('<span id="'+t+'">'+data.message+'</span>');
		
		// get wait time
		if (data.wait_time)
		{			
			wait_time = data.wait_time; // if we specified a wait time use that
		}
				
		// if waittime is greater than zero we will set a time out to remove the message
		if (wait_time > 0)
		{
			// clear message after waiting			
			setTimeout(function(){$('#message').remove();},wait_time);
		}		
		
		//on click remove message
		div.click(function(){$('#message').remove();});				
	};
})( jQuery );
