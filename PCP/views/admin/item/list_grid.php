<?php 
	if (isset($items))
	{
?>
<fieldset>
	<legend>items</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Label</th>
			<th>Cell Id</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($items as $item) { ?>
		<tr>
			<td><?php echo ($item->grid_item_id); ?></td>
			<td><?php echo ($item->label); ?></td>
			<td><?php echo ($item->cell_id); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?grid_item_id='.$item->grid_item_id); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'deleteItem'))).'?grid_item_id='.$item->grid_item_id); ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
