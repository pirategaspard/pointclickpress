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
	/*
		if browser supports javascript then 
		the href atribute will be removed and we will use
		the ajax method below instead. otherwise page will refresh 
		everytime user clicks on a cell
	*/
	var grid_a = $('#grid>a');
	grid_a.removeAttr('href'); 	
	// attach ajax listener to cell click
	grid_a.live('click',function(event) {
			/* 
				On click send the number of the cell to the 
				cellClick function in the PCP controller
			*/
			$().wait_start();
			var cell = $(event.target);
			$.getJSON('cellClick',{n: cell.attr('n'),t: new Date().getTime()},parseData);
	});; 
	
	// attach ajax listener to all grid cells
	$('#grid>div>form').live('submit',function(event) {
			/* 
				On click send the number of the cell to the 
				itemClick function in the PCP controller
			*/
			event.preventDefault();
			$().wait_start();
			var f = $(event.target);
			$.getJSON('itemClick',{n: f.attr('n'),i: f.attr('i'),t: new Date().getTime()},parseData);
		});
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
			if (events[i].function_name == 'NOP')
			{
				// cache the response
			}
			else
			{
				// attempt to do event function			
				eval('$().'+ events[i].function_name + '(events[i].data)');
			}					
		}
	}
	// we are done with the request, go back to pointing
	$().wait_stop();
}

// these functions control the loading bar at the bottom of the scene
(function( $ )
{
	$.fn.wait_start = function() 
  	{ 
		var scene = $('#scene');
			scene.removeClass('pointing');
			scene.addClass('waiting');
	};
	
	$.fn.wait_stop = function() 
  	{ 
		var scene = $('#scene');
			scene.removeClass('waiting');
			scene.addClass('pointing');
	};
	  
})( jQuery );
