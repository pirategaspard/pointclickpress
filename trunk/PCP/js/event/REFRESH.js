// Refreshes the scene. 
// Requires refresh.php 
(function( $ ){
  $.fn.REFRESH = function(data) 
  {  
	// pre-load image and then swap background
	var img = new Image();
	$(img).load(function() {
			$('#grid').css({backgroundImage:'url('+this.src+')'});
		}).attr('src', data.filename);
		$('#title').html(data.title);
		$('#description').html(data.description);	
  };
})( jQuery );
