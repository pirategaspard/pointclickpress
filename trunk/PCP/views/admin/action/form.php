<?php 

	//var_dump($action_types); die();
	if (isset($action) && (isset($action_defs)))
	{
?>
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
		<form method="post" action="<?php echo($action_form_action); ?>">
			<?php if (isset($story_id)){ ?><input type="hidden" name="story_id" value="<?php echo($story_id); ?>" /> <?php } ?>
			<?php if (isset($location_id)){ ?><input type="hidden" name="location_id" value="<?php echo($location_id); ?>" /> <?php } ?>
			<?php if (isset($scene_id)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" /> <?php } ?>
			<?php if (isset($itemdef_id)){ ?><input type="hidden" name="itemdef_id" value="<?php echo($itemdef_id); ?>" /> <?php } ?>
			<?php if (isset($itemstate_id)){ ?><input type="hidden" name="itemstate_id" value="<?php echo($itemstate_id); ?>" /> <?php } ?>
			<?php if (isset($griditem_id)){ ?><input type="hidden" name="griditem_id" value="<?php echo($griditem_id); ?>" /> <?php } ?>
			<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
			<input type="hidden" name="action_type" value="<?php echo($action_type); ?>" />
			<input type="hidden" name="id" value="<?php echo($action->id); ?>" />
			Event Type:
			<select id="action_type2" name="event">
				<?php foreach($action_defs as $action_def)
				{
					$selected = '';
					if ($action->action == $action_def->getClass()) $selected = ' selected="selected" ';
					echo ('<option value="'.$action_def->getClass().'"'.$selected.' >'.$action_def->getLabel().'</option>');
				} ?>
			</select><br />
			<div id="action_description2" class="action_description"></div>
			<label id="action_value" for="action_value">Event Value:
				<textarea rows="10" cols="50" name="action_value"><?php echo($action->action_value); ?></textarea>
			</label>
			<input type="submit" name="submit" value="Save" class="ui-widget ui-state-default ui-corner-all button save" />
		</form>
	</fieldset>
<?php } ?>



<script >
	var action_descriptions2 = Array();
<?php 
	foreach($action_defs as $action_def)
	{
		echo ("action_descriptions2['".$action_def->getClass()."'] = '".htmlentities($action_def->getdescription(),ENT_QUOTES)."';\n "); 
	}
?>
	$('#action_type2').change(function() 
		{
			$('#action_description2').html(action_descriptions2[$(this).val()]);		
		});
	$('#action_type').change();
</script>
