/*
	Admin.js controls the user's interaction with the grid 
	when assigning actions. 
	 
	Users DO need javascript in order to use PCP admin.
 */
$(document).ready(function() {
		
	// when action type = 'event_link' hide the event_value field
	$('#event_type').change(function() {
		if ($(this).val() == 'event_link')
		{	
			$('#location_select').show();		
			$('#event_value').hide();			
		}
		else
		{
			$('#location_select').hide();
			$('#event_value').show();
		}
	});
	
	// when location select is changed update the 'event_value' field
	$('select[name="location_select"]').mouseout(function() {														
		$('textarea[name=event_value]').val($('select[name="location_select"]').val());			
	});
	
	// change grid color based on cell_id list
	$('input[name=cell_ids]').focusout(function() {
		//reset grid to have no selected cells
		var cells = $('#grid').children('b'); //get the cells that are selected
		cells.removeClass('selected'); 
		cells.addClass('not_selected');

		// for cells in cell_id list, add selected class
		current_cells = $(this).val().split(','); // get the cell_id list			
		for(i=0;i<current_cells.length;i++)			
		{				
			$('b[n="'+current_cells[i]+'"]').addClass('selected');
		}
	});

	// catch grid clicks and update the cell_id list
	$('#grid').children('b').click(function() {
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
	
	//when the page loads fire these events to set up the form
	$('#event_type').change();
	$('input[name=cell_ids]').focusout();
	$('input[name=cell_id]').focusout();
	// set cancel button link
	$('#button_cancel').click(function()
		{
			scene_id = $(this).attr('scene_id');
			document.location.href='edit?scene_id='+scene_id;
		});
});		
