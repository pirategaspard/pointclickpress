// shows the user a message 
(function( $ )
{
	$.fn.USER_MESSAGE = function() 
	{  
		// get 'user_message' in story_data from the API 
		var response = $.getJSON('API?USER_MESSAGE',function(data)
		{
			//alert(data.USER_MESSAGE);			
			div = $('#user_message');			
			if (div.length == 0)
			{		
				$('#scene').append('<div id="user_message">'+data.USER_MESSAGE+'</div>');
				div = $('#user_message');
			}
			else
			{
				div.html(data.USER_MESSAGE);
			}
			
			setTimeout(function(){div.html('');},5000);			
		});
	};
})( jQuery );
