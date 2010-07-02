<?php 

	//var_dump($event_types); die();
	if (isset($event) && (isset($event_types)))
	{
?>
	<form method="post" action="<?php echo($event_form_action); ?>">
		<?php if (isset($story_id)){ ?><input type="hidden" name="story_id" value="<?php echo($story_id); ?>" /> <?php } ?>
		<?php if (isset($container_id)){ ?><input type="hidden" name="container_id" value="<?php echo($container_id); ?>" /> <?php } ?>
		<?php if (isset($scene_id)){ ?><input type="hidden" name="scene_id" value="<?php echo($scene_id); ?>" /> <?php } ?>
		<input type="hidden" name="back_url" value="<?php echo($back_url); ?>" />
		<input type="hidden" name="type" value="<?php echo($type); ?>" />
		<input type="hidden" name="id" value="<?php echo($event->id); ?>" />
		Event Type:
		<select id="event_type" name="event">
			<?php foreach($event_types as $event_type)
			{
				$selected = '';
				if ($event->event == $event_type->event) $selected = ' selected="selected" ';
				echo ('<option value="'.$event_type->event.'"'.$selected.' >'.$event_type->label.'</option>');
			} ?>
		</select><br />
		<label id="event_value" for="event_value">Event Value:
			<textarea name="event_value"><?php echo($event->event_value); ?></textarea>
		</label>
		<input type="submit" name="submit" value="submit" />
	</form>
<?php } ?>
