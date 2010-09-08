<?php 
	if (isset($images))
	{
?>
<?php //if (isset($image_add)) echo($image_add); ?>
		<fieldset>
			<legend>Scene images</legend>
			<table>
				<tr>
					<th>Id</th>
					<th>Filename</th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($images as $image) { ?>
				<tr>
					<td><?php echo($image->id); ?></td>
					<td><?php echo($image->filename); ?></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit'))).'?image_id='.$image->id); ?>">Edit</a></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'delete'))).'?image_id='.$image->id); ?>">Delete</a></td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
<?php } ?>
