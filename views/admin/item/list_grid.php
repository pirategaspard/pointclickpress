<?php 
	if (count($griditems) > 0)
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Grid Items</legend>
	<table>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Cell Id</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($griditems as $griditem) { ?>
		<tr>
			<td><?php echo ($griditem->id); ?></td>
			<td><?php echo ($griditem->itemdef_title); ?></td>
			<td><?php echo ($griditem->cell_id); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?tab=2&scene_id='.$griditem->scene_id.'&griditem_id='.$griditem->id); ?>" class="ui-widget ui-state-default ui-corner-all button">Edit</a></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'griditem','action'=>'edit'))).'?griditem_id='.$griditem->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit Properties</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'deleteItem'))).'?tab=2&scene_id='.$griditem->scene_id.'&griditem_id='.$griditem->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete">Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
