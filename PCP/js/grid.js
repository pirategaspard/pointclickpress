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
			$.post('cellClick', {n: $(this).attr('n')}, parseData);
	});; 
});


function parseData(data)
{
	if (data.length > 0)
	{			
		// get array of events from list 
		events = data.split(','); 
		// loop over events 
		for(i=0;i<events.length;i++)
		{	
			
			if(events[i].length > 0)
			{	
				// attempt to do function				
				eval('$().'+ events[i] + '()');
			}			
		}
	}
}