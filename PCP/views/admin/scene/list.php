<?php 
	if (isset($scenes)) 
	{
?>
		<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
			<!-- <legend>location <?php //print($location->id); ?> Scenes</legend> -->
			<table>
				<tr>
					<th>id</th>
					<th>title</th>
					<th>value</th>			
					<th></th>
					<th></th>
					<th></th>
				</tr>			
			<?php foreach ($scenes as $scene) { ?>
				<tr>
					<td><?php echo($scene->id); ?></td>
					<td><?php echo($scene->title); ?></td>
					<td><?php echo($scene->value); ?></td>			
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?story_id='.$scene->story_id.'&location_id='.$scene->location_id.'&scene_id='.$scene->id); ?>">Edit</a></td>
					<td>&nbsp;&nbsp;</td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'delete'))).'?story_id='.$scene->story_id.'&location_id='.$scene->location_id.'&scene_id='.$scene->id); ?>">Delete</a></td>
				</tr>
			<?php } ?>
			</table>
		</fieldset>
<?php } ?>
