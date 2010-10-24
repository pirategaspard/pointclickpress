<?php 
	if (isset($itemimages))
	{
?>
<fieldset>
	<legend>ItemImages</legend>
	<table>
		<tr>
			<th>Id</th>
			<th></th>
			<th>Value</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($itemimages as $itemimage) { ?>
		<tr>
			<td><?php echo ($itemimage->id); ?></td>
			<td><img src="<?php print(Kohana::$base_url.MEDIA_PATH.'/'.$item->story_id.'/'.$itemimage->image_id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$itemimage->filename); ?>" ></td>
			<td><?php echo ($itemimage->value); ?></td>			
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemimage','action'=>'edit'))).'?itemimage_id='.$itemimage->id); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemimage','action'=>'delete'))).'?itemimage_id='.$itemimage->id); ?>" >Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
