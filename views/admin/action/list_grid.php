<?php 
	if (isset($actions))
	{
?>
<!-- <a href="<?php //echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'edit'))).'?action_id=0'.$url_params); ?>">Add Event</a> -->
<fieldset>
	<legend>Actions</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Event</th>
			<th>Value</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($actions as $action) { ?>
		<tr>
			<td><?php echo ($action->id); ?></td>
			<td><?php echo ($action->action_label); ?></td>
			<td><?php 
					if (strlen($action->action_value) > 100 )
					{
						echo (substr($action->action_value,0,100).'...');
					}
					else
					{
						echo ($action->action_value);
					} 
				?>
			</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?scene_id='.$scene_id.'&action_id='.$action->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'delete'))).'?scene_id='.$scene_id.'&action_id='.$action->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
