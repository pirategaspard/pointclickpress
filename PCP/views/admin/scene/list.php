<?php 
	if (!isset($scenes)) $scenes = $container->scenes;
	if ($container->id > 0)
	{
?>
<fieldset>
	<legend>Container <?php print($container->id); ?> Scenes</legend>
	<table>
		<tr>
			<th>id</th>
			<th>title</th>
			<th>value</th>			
			<th></th>
			<th></th>
		</tr>			
	<?php foreach ($scenes as $scene) { ?>
		<tr>
			<td><?php echo($scene->id); ?></td>
			<td><?php echo($scene->title); ?></td>
			<td><?php echo($scene->value); ?></td>			
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?story_id='.$story->id.'&container_id='.$container->id.'&scene_id='.$scene->id); ?>">Edit</a></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'delete'))).'?story_id='.$story->id.'&container_id='.$container->id.'&scene_id='.$scene->id); ?>">Delete</a></td>
		</tr>
	<?php } ?>
	</table>
</fieldset>
<?php } ?>
