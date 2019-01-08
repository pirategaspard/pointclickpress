<script>
// when action type = 'action_inventory_use' hide the action_value field
	$('#action_select').change(function() 
	{		
		if ($(this).val() == 'action_inventoryuse')
		{	
			$('#location_select').hide();			
			var obj = $('#item_Select'); 
			obj.val($('textarea[name=action_value]').val().split(',')[0]);
			$('#item_Select option[value='+obj.val()+']').attr('selected','selected');
			obj.show();			
			obj.change();								
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
