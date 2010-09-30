// Refreshes the scene. 
// Requires refresh.php 
(function( $ )
{
	$.fn.REFRESH = function(data) 
  	{  
	  	// Attempt to load a low res image before fetching the highres 
	  	if($.browser.msie && parseFloat($.browser.version) < 7)
		{
			// if we are IE 6 or lower we can't stretch a background image so do nothing
	  	}
	  	else
	  	{
			// load low res image background and stretch it to fill scene 
		  	var css = {
		      	'background-image': 'url('+data.preload_filename+')',
		    	'-o-background-size':'100% 100%, auto auto',
		    	'-moz-background-size':'100% 100%, auto auto',
		    	'-webkit-background-size':'100% 100%, auto auto',
		    	'background-size':'100% 100%, auto auto'
		    }
		  	$('#grid').css(css);
	  	}
	  
		// pre-load high res image and then swap background
		var img = new Image();
		$(img).load(function() 
					{
						$('#grid').css({backgroundImage:'url('+this.src+')'});
					}).attr('src', data.filename);
			document.title = data.title;
			/* $('#title').html(data.title); */
			$('#description').html(data.description);	
	  };
})( jQuery );