// Refreshes the scene. 
// Requires refresh.php 
(function( $ )
{
	$.fn.REFRESH = function(data) 
  	{  
		
		// clear any items in the cells in the grid
		var itemcells = $('#grid').children('div');
		itemcells.each(	function resetCell(i)
						{
							var obj = $(this)
							if (obj)
							{
								obj.replaceWith('<a n="'+obj.attr('n')+'"></a>');
							}
						});
		    		   	
	  	// Attempt to load a low res image before fetching the highres 
	  	if($.browser.msie && parseFloat($.browser.version) < 9)
		{
			// if we are IE 6 or lower we can't stretch a background image so do nothing
	  	}
	  	else
	  	{
			// load low res image background and stretch it to fill scene 
		  /*	var css = {
		      	'background-image': 'url('+data.preload_filename+')',
		      	'background-size':'100% 100%, auto auto',
		    	'-o-background-size':'100% 100%, auto auto',
		    	'-moz-background-size':'100% 100%, auto auto',
		    	'-webkit-background-size':'100% 100%, auto auto'		    	
		    }
		  	$('#grid').css(css); */
	  	}
	  	 		  	
	  	// show items
	  	var cells = $('#grid').children('a');
	  	for(var n in data.items)
		{
			$(cells[n]).replaceWith('<div class="item" n='+n+'><form n='+n+' i='+data.items[n].id+' action="itemclick?n='+n+'" method="post" ><input type="image" src="'+data.items[n].path+'" name="i" value="'+data.items[n].id+'" /></form></div>');
	  	}
		// pre-load high res image and then swap background
		$().wait_start();
		var img = new Image();
		$(img).load(function() 
					{						
						$('#grid').css({backgroundImage:'url('+this.src+')'});						
					}).attr('src', data.filename);
			document.title = data.title;
			/* $('#title').html(data.title); */
			if (data.description.length > 0)
			{
				$('#description').html(data.description).show();
			}
			else
			{
				$('#description').hide();
			}	
		$().wait_stop();
	  };
})( jQuery );
