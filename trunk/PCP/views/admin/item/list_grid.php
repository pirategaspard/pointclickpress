<?php 
	//var_dump($items);
	if (isset($items))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Items</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Cell Id</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($items as $item) { ?>
		<tr>
			<td><?php echo ($item->id); ?></td>
			<td><?php echo ($item->type); ?></td>
			<td><?php echo ($item->cell_id); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?grid_item_id='.$item->id); ?>" class="ui-widget ui-state-default ui-corner-all button">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'deleteItem'))).'?grid_item_id='.$item->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
