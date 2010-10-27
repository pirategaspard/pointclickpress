<?php 
	if (isset($itemstates))
	{
?>
<fieldset>
	<legend>Item States</legend>
	<table>
		<tr>
			<th>Id</th>
			<th></th>
			<th>Value</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($itemstates as $itemstate) { ?>
		<tr>
			<td><?php echo ($itemstate->id); ?></td>
			<td><img src="<?php print(Kohana::$base_url.MEDIA_PATH.'/'.$item->story_id.'/'.$itemstate->image_id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$itemstate->filename); ?>" ></td>
			<td><?php echo ($itemstate->value); ?></td>			
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'edit'))).'?itemstate_id='.$itemstate->id); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'delete'))).'?itemstate_id='.$itemstate->id); ?>" >Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
