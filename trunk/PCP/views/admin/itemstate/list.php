<?php 
	if (isset($itemstates))
	{
?>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
	<?php if (isset($itemstate_add)) echo('<span class="add">'.$itemstate_add."</span>"); ?>
	<legend>Item States</legend>
	<table>
		<tr>
			<th>Id</th>
			<th></th>
			<th>Value</th>
			<th>Default</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach ($itemstates as $itemstate) { ?>
		<tr>
			<td><?php echo ($itemstate->id); ?></td>
			<?php if (strlen($itemstate->image_id > 0)) { ?>
			<td><img src="<?php print(Kohana::$base_url.MEDIA_PATH.'/'.$story_id.'/'.$itemstate->image_id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$itemstate->filename); ?>" ></td>
			<?php } else { ?>
			<td></td>
			<?php } ?>
			<td><?php echo ($itemstate->value); ?></td>	
			<td ><?php if($itemstate->isdefaultstate) {echo '<span style="margin: 0 auto; text-align: center;" class="ui-icon ui-icon-check"></span>';} else {echo '<span style="margin: 0 auto; text-align: center;" class="ui-icon ui-icon-closethick
"></span>';}  ?></td>		
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'edit'))).'?'.$add_id.'&itemstate_id='.$itemstate->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
			<td>&nbsp;&nbsp;</td>
			<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'delete'))).'?'.$add_id.'&itemstate_id='.$itemstate->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
<?php } ?>
