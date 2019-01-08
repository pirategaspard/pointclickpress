<?php 
	if (isset($itemdefs))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<?php if (isset($itemdef_add)) echo('<span class="add">'.$itemdef_add."</span>"); ?>
	<legend>Items</legend>
	<table>
		<tr>
			<th>Id</th> 
			<th>Title</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($itemdefs as $itemdef) { ?>
		<tr>
			<td><?php echo ($itemdef->id); ?></td>
			<td><?php echo ($itemdef->title); ?></td>			
		<?php if(isset($scene_id)) { ?>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?'.$add_id.'&itemdef_id='.$itemdef->id.'&tab=2'); ?>" target="_parent" class="ui-widget ui-state-default ui-corner-all button" >Select</a></td>
			<td>&nbsp;&nbsp;</td>
			<td></td>
		<?php } else { ?>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemdef','action'=>'edit'))).'?'.$add_id.'&itemdef_id='.$itemdef->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemdef','action'=>'delete'))).'?'.$add_id.'&itemdef_id='.$itemdef->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
		<?php }?>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
