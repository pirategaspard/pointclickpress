<script>
// when action type = 'action_inventory_use' hide the action_value field
	$('#action_select').change(function() 
	{		
		if ($(this).val() == 'action_inventory_use')
		{	
			$('#location_select').hide();		
			$('#action_value').hide();			
			$('#item_Select').show();
		}
		else
		{
			$('#item_Select').hide();
		}
		
		//$('#action_description').html(action_descriptions[$(this).val()]);		
	});
	
	// when location select is changed update the 'action_value' field
	$('select[name="item_Select"]').mouseout(function() 
	{														
		$('textarea[name=action_value]').val($('select[name="item_Select"]').val()+',TRIGGER_CELL_ID');			
	});
	
	
</script>
