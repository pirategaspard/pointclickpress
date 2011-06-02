<?php 
	//var_dump($plugins);
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<legend>Installed Plugins</legend>
	<table>
		<tr>
			<td>Status</td>
			<td>Name</td>
			<td>Description</td>
			<td>System-wide plugin</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php foreach ($plugins as $plugin) { ?>
		<tr>
			<td><?php echo ($plugin['status'])?'Active':'Inactive'; ?></td>
			<td><h4><?php echo ($plugin['label']); ?></h4></td>
			<!-- <td><?php echo (substr($plugin['description'],0,25).'...'); ?></td> -->
			<td><?php echo ($plugin['description']); ?></td>	
			<td ><?php if($plugin['system']) {echo '<span style="margin: 0 auto; text-align: center;" class="ui-icon ui-icon-check"></span>';} else {echo '';}  ?></td>			
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'edit'))).'?plugin='.$plugin['class']); ?>" class="ui-widget ui-state-default ui-corner-all button" ><?php echo ($plugin['status'])?'De-activate':'Activate'; ?></a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'delete'))).'?plugin='.$plugin['class']); ?>">UnInstall</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
