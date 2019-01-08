// Refreshes points. 
// Requires action/points.php 
(function( $ )
{
	$.fn.REFRESH_POINTS = function(data) 
  	{  
		var div = $('#points');
		// if points div doesn't exist:
		if (div.length == 0)
		{
			$('#bottommenu').append('<div id="points"></div>');
			div = $('#points');
		}
		div.html('<span>Points: '+data.points+'</span>');
	};
})( jQuery );