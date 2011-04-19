<?php 

	if (isset($action) && (isset($action_defs)))
	{ 
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Grid Action</legend>
	<form method="post" action="<?php echo($grid_action_form_action); ?>">
		<?php if (isset($story_id)){ ?><input type="hidden" name="story_id" value="<?php echo($story_id); ?>" /> <?php } ?>
		<?php if (isset($location_id)){ ?><input type="hidden" name="location_id" value="<?php echo($location_id); ?>" /> <?php } ?>
		<?php if (isset($scene_id)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" /> <?php } ?>
		<?php if (isset($action->grid_action_id)){ ?><input type="hidden" name="grid_action_id" value="<?php echo($action->grid_action_id); ?>" /> <?php } ?>
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="action_type" value="<?php echo($action_type); ?>" />
		<input type="hidden" name="id" value="<?php echo($action->id); ?>" />
		Event Type:
		<select id="action_select" name="action">
			<?php foreach($action_defs as $action_def)
			{
				$selected = '';
				if ($action->action == $action_def->getClass()) $selected = ' selected="selected" ';
				echo ('<option value="'.$action_def->getClass().'"'.$selected.' >'.$action_def->getLabel().'</option>');
			} ?>
		</select>
		<?php Events::announceEvent(DISPLAY_POST_GRID_SELECT); ?>
		<?php if(isset($locations)) { ?>
		<label id="location_select" for="location_select">Scene location:
		<select name="location_select" >
			<option >Select a Scene location</option>
			<?php foreach($locations as $location)
			{
				$selected = '';
				if ($action->action_value == $location->id) $selected = ' selected="selected" ';
				echo ('<option value="'.$location->id.'"'.$selected.' >'.$location->title.'</option>');
			} ?>
		</select>
		</label>
		<?php } ?>
		<label id="action_value" for="action_value">Event Value:
			<textarea rows="5" cols="70" name="action_value"><?php echo($action->action_value); ?></textarea>
		</label>
		<label id="cell_ids" for="cell_ids">Cell Id List:
			<input type="text" name="cell_ids" value="<?php echo($action->getCellIds()); ?>" />
		</label>
		<div id="action_description" class="action_description"></div>
		<input id="button_submit" type="submit" name="submit" value="submit" class="ui-widget ui-state-default ui-corner-all button save" />		
		<?php if($action->id > 0 ) { ?>
		<input type="button" name="cancel" value="cancel" scene_id="<?php echo($scene_id); ?>" class="ui-widget ui-state-default ui-corner-all button cancel button_cancel" />
		<?php } ?>
	</form>
</fieldset>
<?php } ?>

<script >
	var action_descriptions = Array();
<?php 
	foreach($action_defs as $action_def)
	{
		echo ("action_descriptions['".$action_def->getClass()."'] = '".htmlentities($action_def->getdescription(),ENT_QUOTES)."';\n "); 
	}
?>
</script>
