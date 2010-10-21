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
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($items as $item) { ?>
		<tr>
			<td><?php echo ($item->id); ?></td>
			<td><?php echo ($item->label); ?></td>			
		<?php if(isset($scene_id)) { ?>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?item_id='.$item->id); ?>" target="_parent">Assign Item</a></td>
			<td>&nbsp;&nbsp;</td>
			<td></td>
		<?php } else { ?>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'edit'))).'?item_id='.$item->id); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'delete'))).'?item_id='.$item->id); ?>" >Delete</a></td>
		<?php }?>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
