<script>
$(document).ready(function() 
{		
	// when action type = 'action_link' hide the action_value field
	$('#action_select').change(function() 
	{		
		if ($(this).val() == 'action_link')
		{	
			var obj = $('#location_select'); 
			obj.val($('textarea[name=action_value]').val());
			$('#location_select option[value='+obj.val()+']').attr('selected','selected');
			obj.show();			
			obj.change();
			$('#action_value').hide();			
		}
		else
		{			
			$('#location_select').hide();
			$('#action_value').show();
		}
		//$('#action_description').html(action_descriptions[$(this).val()]);		
	});
	
	$('#action_select').change();
	
	// when location select is changed update the 'action_value' field
	$('select[name="location_select"]').mouseout(function() 
	{														
		$('textarea[name=action_value]').val($('select[name="location_select"]').val());			
	});
	

});
</script>
