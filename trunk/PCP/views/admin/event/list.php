<?php 
	if (isset($events))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<?php if (isset($event_add)) echo('<span class="add">'.$event_add."</span>"); ?>
	<legend>Events</legend>
	<table>
		<tr>
			<th>Event</th>
			<th>Value</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($events as $event) { ?>
		<tr>
			<td><?php echo ($event->event_label); ?></td>
			<td><?php 
					if (strlen($event->event_value) > 25 )
					{
						echo (substr($event->event_value,0,25).'...');
					}
					else
					{
						echo ($event->event_value);
					} 
				?>
			</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'edit'))).'?'.$add_id.'&event_id='.$event->id); ?>" class="thickbox ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'delete'))).'?'.$add_id.'&event_id='.$event->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
