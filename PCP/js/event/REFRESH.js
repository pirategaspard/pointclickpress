// Refreshes the scene. 
// Requires refresh.php 
(function( $ ){
  $.fn.REFRESH = function(data) 
  {  
  	// load temp background using low res image
  	var css = {
      	'background-image': 'url('+data.preload_filename+')',
    	'-moz-background-size':'100% 100%, auto auto'
    }
  	$('#grid').css(css);
  
	// pre-load image and then swap background
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
