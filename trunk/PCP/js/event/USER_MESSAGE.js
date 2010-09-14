// shows the user a message 
(function( $ )
{
	$.fn.USER_MESSAGE = function() 
	{  
		// get 'user_message' in story_data from the API 
		var response = $.getJSON('API?USER_MESSAGE',function(data)
		{
			alert(data.USER_MESSAGE);
		});
	};
})( jQuery );
