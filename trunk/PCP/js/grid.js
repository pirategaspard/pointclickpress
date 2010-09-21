/*
  Grid.js is used to control user interaction with each Scene in the 
  Interactive Story.  It will capture user clicks and update the scene 
  if needed.
   
  Users do not need javascript in order to use PCP. 
  The site will refresh the page on each click if they do not have 
  javascript.
  
*/
$(document).ready(function() 
{
	// get all the cells in the grid
	var cells = $('#grid').children('a'); 
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
			$.getJSON('cellClick',{n: $(this).attr('n')},parseData);
			//$.post('cellClick', {n: $(this).attr('n')}, parseData);
	});; 
});

function parseData(events)
{
	// events contains array of pcpresponse objects. 
	// events[i].function_name - name of plugin to execute
	// events[i].data - data for plugin
	if (events.length > 0)
	{					
		// loop over events 
		for(i=0;i<events.length;i++)
		{	
			// attempt to do event function			
			eval('$().'+ events[i].function_name + '(events[i].data)');					
		}
	}
}