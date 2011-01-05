<?php 

	//var_dump($event_types); die();
	if (isset($event) && (isset($event_defs)))
	{
?>
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
		<form method="post" action="<?php echo($event_form_action); ?>">
			<?php if (isset($story_id)){ ?><input type="hidden" name="story_id" value="<?php echo($story_id); ?>" /> <?php } ?>
			<?php if (isset($location_id)){ ?><input type="hidden" name="location_id" value="<?php echo($location_id); ?>" /> <?php } ?>
			<?php if (isset($scene_id)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" /> <?php } ?>
			<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
			<input type="hidden" name="event_type" value="<?php echo($event_type); ?>" />
			<input type="hidden" name="id" value="<?php echo($event->id); ?>" />
			Event Type:
			<select id="event_type2" name="event">
				<?php foreach($event_defs as $event_def)
				{
					$selected = '';
					if ($event->event == $event_def->getClass()) $selected = ' selected="selected" ';
					echo ('<option value="'.$event_def->getClass().'"'.$selected.' >'.$event_def->getLabel().'</option>');
				} ?>
			</select><br />
			<div id="event_description2" class="event_description"></div>
			<label id="event_value" for="event_value">Event Value:
				<textarea rows="10" cols="50" name="event_value"><?php echo($event->event_value); ?></textarea>
			</label>
			<input type="submit" name="submit" value="Save" class="ui-widget ui-state-default ui-corner-all button save" />
		</form>
	</fieldset>
<?php } ?>



<script >
	var event_descriptions2 = Array();
<?php 
	foreach($event_defs as $event_def)
	{
		echo ("event_descriptions2['".$event_def->getClass()."'] = '".htmlentities($event_def->getdescription(),ENT_QUOTES)."';\n "); 
	}
?>
	$('#event_type2').change(function() 
		{
			$('#event_description2').html(event_descriptions2[$(this).val()]);		
		});
	$('#event_type').change();
</script>
