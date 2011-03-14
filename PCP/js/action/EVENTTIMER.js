// Requires eventimer.php
(function( $ )
{
	$.fn.EVENTTIMER = function(data) 
	{  
		setTimeout(function()
		{
			$.getJSON('cellClick',{n: data.cell_to_click},parseData);
		},data.wait_time);
	};
})( jQuery );