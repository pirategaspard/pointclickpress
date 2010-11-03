<?php 
	if (isset($stories))
	{	
?>
		<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
			<legend>Your Interactive Stories</legend>
			<table>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($stories as $story) { ?>
				<tr>
					<td><?php echo($story->id); ?></td>
					<td><?php echo($story->title); ?></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit'))).'?story_id='.$story->id); ?>">Edit</a></td>
					<td>&nbsp;&nbsp;</td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'delete'))).'?story_id='.$story->id); ?>">Delete</a></td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
<?php } ?>