// Refreshes items in the scene. 
// Requires refreshitems.php 
(function( $ )
{
	$.fn.REFRESH_ITEMS = function(data) 
  	{    		
		// clear any items in the cells in the grid
		var itemcells = $('#grid').children('div');
		itemcells.each(function(){
			var obj = $(this)
			obj.replaceWith('<a n="'+obj.attr('n')+'"></a>');
		});
	  		  	
	  	// show items
	  	var cells = $('#grid').children('a');
	  	for(var n in data.items)
		{
			//$(cells[n]).html('<img src="'+data.items[n]+'" />');
			$(cells[n]).replaceWith('<div n='+n+'><form n='+n+' i='+data.items[n].id+' action="itemclick?n='+n+'" method="post" ><input type="image" src="'+data.items[n].path+'" name="i" value="'+data.items[n].id+'" /></form></div>');
	  	}
	};	
})( jQuery );