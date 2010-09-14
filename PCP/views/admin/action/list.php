<?php 
	if ($scene->id > 0)
	{
?>
<fieldset>
	<legend>Scene <?php print($scene->id); ?> Actions</legend>
	<table>
		<tr>
			<td>id</td>
			<td>event</td>
			<td>value</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php foreach ($actions as $action) { ?>
		<tr>
			<td><?php echo ($action->id); ?></td>
			<td><?php echo ($action->event_label); ?></td>
			<td><?php echo ($action->event_value); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'edit'))).'?story_id='.$scene->story_id.'&container_id='.$scene->container_id.'&scene_id='.$scene->id.'&action_id='.$action->id); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'delete'))).'?story_id='.$scene->story_id.'&container_id='.$scene->container_id.'&scene_id='.$scene->id.'&action_id='.$action->id); ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
