<?php 
	if (isset($locations))
	{
?>
<?php //if (isset($location_add)) echo($location_add); ?>
		<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
			<legend>Locations</legend>
			<table>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($locations as $location) { ?>
				<tr>
					<td><?php echo($location->id); ?></td>
					<td><?php echo($location->title); ?></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit'))).'?story_id='.$location->story_id.'&location_id='.$location->id); ?>">Edit</a></td>
					<td>&nbsp;&nbsp;</td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'location','action'=>'delete'))).'?story_id='.$location->story_id.'&location_id='.$location->id); ?>">Delete</a></td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
<?php } ?>
