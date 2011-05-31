<script>
$(document).ready(function() 
{
	// when action type = 'action_link' hide the action_value field
	$('#action_select').change(function() 
	{		
		if ($(this).val() == 'action_link')
		{	
			$('#location_select').val($('textarea[name=action_value]').val()).attr("selected","selected");
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
	
	//when the page loads fire these events to set up the form (if it exists)
	$('#action_select').change();
});
</script>
