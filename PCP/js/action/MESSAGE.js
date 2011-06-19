// Creates a simple user message. 
// Requires message.php
(function( $ )
{
	$.fn.MESSAGE = function(data) 
	{  		
		var t = new Date().getTime();
		var div = $('#message>.container');
		// if message div doesn't exist, create it			
		if (div.length == 0)
		{		
			// if message div doesn't exist, create it
			$('#description').before('<p id="message"><span class="container"></span></p>');
			div = $('#message>.container');
		}

		// add message to message div
		div.html('<span class="text" id="'+t+'">'+data.message+'</span>');
		//div.append('<span id="'+t+'">'+data.message+'</span>');
		
		// get wait time
		if (data.wait_time)
		{
			// if we specified a wait time use that
			wait_time = data.wait_time; 
			// clear message after waiting			
			setTimeout(function(){$('#message').remove();},wait_time);
		}
				
		//clear on click
		div.click(function(){$('#message').remove();});
				
	};
})( jQuery );
