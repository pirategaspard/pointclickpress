<?php 
	if (isset($locations))
	{
?>
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
		<?php if (isset($location_add)) echo('<span class="add">'.$location_add."</span>"); ?>
		<legend>Locations</legend>
		<table>
			<tr>
				<th>Title</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<?php foreach($locations as $location) { ?>
			<tr>
				<td><h4><?php echo($location->title); ?></h4></td>
				<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit'))).'?story_id='.$location->story_id.'&location_id='.$location->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
				<td>&nbsp;&nbsp;</td>
				<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'location','action'=>'delete'))).'?story_id='.$location->story_id.'&location_id='.$location->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
<?php } ?>
