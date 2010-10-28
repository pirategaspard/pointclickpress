// Refreshes items in the scene. 
// Requires refreshitems.php 
(function( $ )
{
	$.fn.REFRESH_ITEMS = function(data) 
  	{    		
		// clear any items in the cells in the grid
		var cells = $('#grid').children('a');
		cells.empty();
	  		  	
	  	// show items
	  	for(var i in data.items)
		{
			$(cells[i]).html('<img src="'+data.items[i]+'" />');
	  	}
	};	
})( jQuery );
