<?php 
	if (!isset($containers)) $containers = $story->containers;
	if ($story->id > 0)
	{
?>

<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit'))).'?story_id='.$story->id.'&container_id=0'); ?>">Add container</a>
<fieldset>
	<legend>Scene Containers</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($containers as $container) { ?>
		<tr>
			<td><?php echo($container->id); ?></td>
			<td><?php echo($container->title); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit'))).'?story_id='.$story->id.'&container_id='.$container->id); ?>">Edit</a></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'container','action'=>'delete'))).'?story_id='.$story->id.'&container_id='.$container->id); ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
