<?php 
	//var_dump($plugins);
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Available Plugins</legend>
	<table>
		<tr>
			<td>Status</td>
			<td>Name</td>
			<td>Description</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php foreach ($plugins as $plugin) { ?>
		<tr>
			<td><?php echo ($plugin->status)?'Active':'Inactive'; ?></td>
			<td><h4><?php echo ($plugin->label); ?></h4></td>
			<!-- <td><?php echo (substr($plugin->description,0,25).'...'); ?></td> -->
			<td><?php echo ($plugin->description); ?></td>				
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'storyplugin','action'=>'ChangeStatus'))).'?storyplugin_id='.$plugin->storyplugin_id.'&plugin_id='.$plugin->plugin_id); ?>" class="ui-widget ui-state-default ui-corner-all button" ><?php echo ($plugin->status)?'De-activate':'Activate'; ?></a></td>
			<td>&nbsp;&nbsp;</td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
