<?php 
	if (isset($items))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<legend>Items</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($items as $item) { ?>
		<tr>
			<td><?php echo ($item->id); ?></td>
			<td><?php echo ($item->title); ?></td>			
		<?php if(isset($scene_id)) { ?>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?item_id='.$item->id); ?>" target="_parent" class="ui-widget ui-state-default ui-corner-all button" >Assign Item</a></td>
			<td>&nbsp;&nbsp;</td>
			<td></td>
		<?php } else { ?>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'edit'))).'?item_id='.$item->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'delete'))).'?item_id='.$item->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
		<?php }?>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
