/*
	Admin.js controls the user's interaction with the grid 
	when assigning actions. 
	 
	Users DO need javascript in order to use PCP admin.
 */
// TODO: reorganize this file
$(document).ready(function() {
		
	// action_link could be re-factored as a plugin and get this code out of here.
	// when action type = 'action_link' hide the action_value field
	$('#action_type').change(function() 
	{		
		if ($(this).val() == 'action_link')
		{	
			$('#location_select').show();		
			$('#action_value').hide();			
		}
		else
		{
			$('#location_select').hide();
			$('#action_value').show();
		}
		
		$('#action_description').html(action_descriptions[$(this).val()]);		
	});
	
	// when location select is changed update the 'action_value' field
	$('select[name="location_select"]').mouseout(function() 
	{														
		$('textarea[name=action_value]').val($('select[name="location_select"]').val());			
	});
	
	// change grid color based on cell_id list
	$('input[name=cell_ids]').focusout(function() 
	{
		//reset grid to have no selected cells
		var cells = $('#grid').children('b'); //get the cells that are selected
		cells.removeClass('selected'); 
		cells.addClass('not_selected');

		// for cells in cell_id list, add selected class
		current_cells = $(this).val().split(','); // get the cell_id list			
		for(i=0;i<=current_cells.length;i++)			
		{				
			$('b[n="'+current_cells[i]+'"]').addClass('selected');
		}
	});

	// catch grid clicks and update the cell_id list
	$('#grid').children('b').click(function() 
	{
		var list = '';
		var newcss = '';
		var cell_id = $(this).attr('n');
		var grid_cell_id_list = $('input[name=cell_ids]'); 
		$('input[name=cell_id]').val(cell_id);
		var current_cells = grid_cell_id_list.val();		
		if (current_cells.indexOf(cell_id) < 0)
		{	
			//if cell isn't in list add to list. 						
			if (current_cells.length > 0)
			{
				list = current_cells+','+cell_id; 
			}
			else
			{
				list = cell_id; 
			}			
		}
		else
		{	
			// remove cell from item cell 
			$('input[name=cell_id]').val('');
			// if the cell is already selected, remove it from list
			current_cells = current_cells.split(',');
			if (current_cells.length > 1)
			{
				current_cells.splice(current_cells.indexOf(cell_id), 1);
				list = current_cells.toString();
			}			
		}									
		grid_cell_id_list.val(list); //set the new values for the cell and cell_id list					
		grid_cell_id_list.focusout(); // focus on cell_ids input field so that the grid will update
	});
	
	// catch delete clicks and confirm delete	
	$('.delete').click(function(d)
	{
		d.preventDefault();
		var delete_link = $(this).attr('href');
		$("#dialog_delete").dialog(
			{
				title: 'Confirm Delete'
				,modal: true
				,buttons: [
					{
						text: 'Delete',
						click: function() { window.location.href = delete_link; }
					}
					,{
						text: 'cancel',
						click: function() { $(this).dialog("close"); }
					}
				]
			});
	});
	
	// set cancel button link
	$('.button_cancel').click(function()
	{
		scene_id = $(this).attr('scene_id');
		document.location.href='edit?scene_id='+scene_id;
	});
	
	// if messages div has content show in pop-up
	if (messages = $('#dialog_message'))
	{		
		if (messages.children('p').html()) /* && messages.children('p').html().length > 0)  */
		{
			//messages.css('display','block');
			$("#dialog_message").dialog(
					{ 
						title: 'Message'
						,buttons: [
					    {
					        text: 'Close',
					        click: function() { $(this).dialog("close"); }
					    }]
					});		
		}
	}
	
	//when the page loads fire these events to set up the form (if it exists)
	$('#action_type').change();
	$('input[name=cell_ids]').focusout();
	$('input[name=cell_id]').focusout();
				
	// jQuery UI init
    $("#accordion").accordion({ collapsible: true, active: false, animated: false }); //autoHeight: true
    $("#tabs").tabs();
    
    // select tab (if tab param exists)
    params = getQueryParams();
    if (params['tab']) 
    {
		$("#tabs").tabs('select',params['tab']);
	}
});	

function getQueryParams()
{
	var items = new Array()
	var queryParamString = document.location.toString().split('?');
	if (queryParamString.length > 0)
	{
		if (queryParamString[1])
		{
			params = queryParamString[1].split('&');
			for(i=0;i<params.length;i++)
			{
				item = params[i].split('=');
				items[item[0]] = unescape(item[1]);
			}
		}
	}
	return items;
}	
