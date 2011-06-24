<?php 
	if (isset($actions))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<?php if (isset($action_add)) echo('<span class="add">'.$action_add."</span>"); ?>
	<legend>Actions</legend>
	<table>
		<tr>
			<th>Action</th>
			<th>Value</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($actions as $action) { ?>
		<tr>
			<td><?php echo ($action->action_label); ?></td>
			<td><?php 
					if (strlen($action->action_value) > 100 )
					{
						echo (substr($action->action_value,0,100).'...');
					}
					else
					{
						echo ($action->action_value);
					} 
				?>
			</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'edit'))).'?'.$add_id.'&action_id='.$action->id); ?>" class="thickbox ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'delete'))).'?'.$add_id.'&action_id='.$action->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
