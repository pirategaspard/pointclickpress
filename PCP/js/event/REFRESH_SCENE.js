// refreshes a scene
(function( $ ){
  $.fn.REFRESH_SCENE = function() 
  {  
    var filename = $.getJSON('Scene',function(data)
	{						
		// pre-load image and then swap background
		var img = new Image();
		$(img).load(function() {
				$('#scene_image').css({backgroundImage:'url('+this.src+')'});
			}).attr('src', data.filename);
			$('#scene>h1').html(data.title);
			$('#scene>p').html(data.description);	
	});
  };
})( jQuery );
