<?php 
	//var_dump($plugins);
?>
<fieldset>
	<legend>Installed Plugins</legend>
	<table>
		<tr>
			<td>status</td>
			<td>name</td>
			<td>description</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php foreach ($plugins as $plugin) { ?>
		<tr>
			<td><?php echo ($plugin['status'])?'Active':'Inactive'; ?></td>
			<td><?php echo ($plugin['label']); ?></td>
			<td><?php echo (substr($plugin['description'],0,25).'...'); ?></td>			
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'edit'))).'?plugin='.$plugin['class']); ?>"><?php echo ($plugin['status'])?'De-activate':'Activate'; ?></a></td>
			<td>&nbsp;&nbsp;</td>
			<!-- <td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'delete'))).'?plugin='.$plugin['class']); ?>">UnInstall</a></td> -->
		</tr>
		<?php } ?>
	</table>
</fieldset>
