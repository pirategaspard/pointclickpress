<?php 

	//var_dump($event_types); die();

	if (isset($event) && (isset($event_types)))
	{ 
?>
	<form method="post" action="<?php echo($grid_event_form_action); ?>">
		<?php if (isset($story_id)){ ?><input type="hidden" name="story_id" value="<?php echo($story_id); ?>" /> <?php } ?>
		<?php if (isset($container_id)){ ?><input type="hidden" name="container_id" value="<?php echo($container_id); ?>" /> <?php } ?>
		<?php if (isset($scene_id)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" /> <?php } ?>
		<?php if (isset($event->grid_event_id)){ ?><input type="hidden" name="grid_event_id" value="<?php echo($event->grid_event_id); ?>" /> <?php } ?>
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="type" value="<?php echo($type); ?>" />
		<input type="hidden" name="id" value="<?php echo($event->id); ?>" />
		Event Type:
		<select id="event_type" name="event">
			<?php foreach($event_types as $event_type)
			{
				$selected = '';
				if ($event->event == $event_type->getEvent()) $selected = ' selected="selected" ';
				echo ('<option value="'.$event_type->getEvent().'"'.$selected.' >'.$event_type->getLabel().'</option>');
			} ?>
		</select>
		<?php if(isset($containers)) { ?>
		<label id="container_select" for="container_select">Scene Container:
		<select name="container_select" >
			<option >Select a Scene Container</option>
			<?php foreach($containers as $container)
			{
				$selected = '';
				if ($event->event_value == $container->id) $selected = ' selected="selected" ';
				echo ('<option value="'.$container->id.'"'.$selected.' >'.$container->title.'</option>');
			} ?>
		</select>
		</label>
		<?php } ?>
		<label id="event_value" for="event_value">Event Value:
			<textarea rows="3" cols="50" name="event_value"><?php echo($event->event_value); ?></textarea>
		</label>
		<label id="cell_ids" for="cell_ids">Cell Id List:
			<input type="text" name="cell_ids" value="<?php echo($event->getCellIds()); ?>" />
		</label>
		<input type="submit" name="submit" value="submit" />
	</form>
<?php } ?>
