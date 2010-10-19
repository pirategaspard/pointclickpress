<?php 
	if (isset($items))
	{
?>
<fieldset>
	<legend>items</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Filename</th>
			<th>Cell Id</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($items as $item) { ?>
		<tr>
			<td><?php echo ($item->id); ?></td>
			<td><?php echo ($item->filename); ?></td>
			<td><?php echo ($item->cell_id); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?item_id='.$item->id); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'delete'))).'?item_id='.$item->id); ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
