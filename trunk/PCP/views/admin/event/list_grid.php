<?php 
	if (isset($events))
	{
?>
<!-- <a href="<?php //echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'edit'))).'?event_id=0'.$url_params); ?>">Add Event</a> -->
<fieldset>
	<legend>Events</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Event</th>
			<th>Value</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($events as $event) { ?>
		<tr>
			<td><?php echo ($event->id); ?></td>
			<td><?php echo ($event->event_label); ?></td>
			<td><?php 
					if (strlen($event->event_value) > 15 )
					{
						echo (substr($event->event_value,0,15).'...');
					}
					else
					{
						echo ($event->event_value);
					} 
				?>
			</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?event_id='.$event->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'delete'))).'?event_id='.$event->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
