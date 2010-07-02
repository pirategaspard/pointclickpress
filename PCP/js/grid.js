/*
  Grid.js is used to control user interaction with each Scene in the 
  Interactive Story.  It will capture user clicks and update the scene 
  if needed.
   
  Users do not need javascript in order to use PCP. 
  The site will refresh the page on each click if they do not have 
  javascript.
  
  
*/
$(document).ready(function() {
	
	// get all the cells in the grid
	var cells = $('#scene_image').children('a'); 
	
	/*
		if browser supports javascript then 
		the href atribute will be removed and we will use
		the ajax method below instead. otherwise page will refresh 
		everytime user clicks on a cell
	*/
	cells.removeAttr('href'); 
	
	// attach ajax listener to cell click
	cells.click(function() {
			/* 
				On click send the number of the cell to the cellClickAjax
				function in	the PCP controller
			*/
			$.post('cellClick', {n: $(this).attr('n')}, function(data) {
			if (data == 1)
			{
				//get scene and swap the data so we don't have to reload the page!
				var filename = $.getJSON('getScene',function(data){						
						$('#scene>h1').html(data.title);
						$('#scene>p').html(data.description);						
						// pre-load image and then swap background
						var img = new Image();
						$(img).load(function() {
								$('#scene_image').css({backgroundImage:'url('+this.src+')'});
							}).attr('src', data.filename);
						});
			}
		});
	});; 
});