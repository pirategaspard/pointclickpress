<?php 

	//var_dump($event_types);

	if (strlen($scene->filename) > 0) 
	{ 
?>
	<form method="post" action="<?php echo($actions_form_action); ?>">
		<input type="hidden" name="story_id" value="<?php echo($scene->story_id); ?>" />
		<input type="hidden" name="container_id" value="<?php echo($action->container_id); ?>" />
		<input type="hidden" name="scene_id" value="<?php echo($action->scene_id); ?>" />
		<input type="hidden" name="id" value="<?php echo($action->id); ?>" />
		Action Type:
		<select id="event_type" name="event">
			<?php foreach($event_types as $event_type)
			{
				$selected = '';
				if ($action->event == $event_type->event) $selected = ' selected="selected" ';
				echo ('<option value="'.$event_type->event.'"'.$selected.' >'.$event_type->label.'</option>');
			} ?>
		</select>
		<label id="container_select" for="container_select">Scene Container:
		<select name="container_select" >
			<option >Select a Scene Container</option>
			<?php foreach($containers as $container)
			{
				$selected = '';
				if ($action->event_value == $container->id) $selected = ' selected="selected" ';
				echo ('<option value="'.$container->id.'"'.$selected.' >'.$container->title.'</option>');
			} ?>
		</select>
		</label>
		<label id="event_value" for="event_value">Event Value:
			<textarea name="event_value"><?php echo($action->event_value); ?></textarea>
		</label>
		<label id="cell_ids" for="cell_ids">Cell Id List:
			<input type="text" name="cell_ids" value="<?php echo($action->getCellIds()); ?>" />
		</label>
		<input type="submit" name="submit" value="submit" />
	</form>
<?php } ?>
<?php echo $action_list ?>
