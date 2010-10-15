<?php 
	//var_dump($plugins);
?>
<fieldset>
	<legend>Installed Plugins</legend>
	<table>
		<tr>
			<td>name</td>
			<td>description</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<?php foreach ($plugins as $plugin) { ?>
		<tr>
			<td><?php echo ($plugin->getLabel()); ?></td>
			<td><?php echo ($plugin->getDescription()); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'edit'))).'?plugin='.$plugin->getClass()); ?>">Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<!-- <td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'delete'))).'?plugin='.$plugin->getClass()); ?>">Delete</a></td> -->
		</tr>
		<?php } ?>
	</table>
</fieldset>
