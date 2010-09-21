// Creates a simple user message. 
// Requires message.php
(function( $ )
{
	$.fn.MESSAGE = function(data) 
	{  		
		div = $('#message');			
		if (div.length == 0)
		{		
			$('#scene').append('<div id="message">'+data.message+'</div>');
			div = $('#message');
		}
		else
		{
			div.html(data.message);
		}		
		setTimeout(function(){div.html('');},5000);			
	};
})( jQuery );
