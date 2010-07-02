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
		</tr>
		<?php foreach ($events as $event) { ?>
		<tr>
			<td><?php echo ($event->id); ?></td>
			<td><?php echo ($event->event_label); ?></td>
			<td><?php echo ($event->event_value); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'edit'))).'?event_id='.$event->id.$url_params); ?>">Edit</a></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'delete'))).'?event_id='.$event->id.$url_params); ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
