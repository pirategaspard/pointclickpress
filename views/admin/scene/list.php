<?php 
	if (isset($scenes)) 
	{
?>
		<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
			<?php if (isset($scene_add)) echo('<span class="add">'.$scene_add."</span>"); ?>
			<legend>Scenes</legend>
			<table>
				<tr>
					<th></th>
					<th>Title</th>
					<th>Value</th>			
					<th></th>
					<th></th>
					<th></th>
				</tr>			
			<?php foreach ($scenes as $scene) { ?>
				<tr>
					<td><img src="<?php echo (Kohana::$base_url.MEDIA_PATH.'/'.$story_id.'/'.$scene->image_id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$scene->filename); ?>" /></td>
					<td><h4><?php echo($scene->title); ?></h4></td>
					<td><?php echo($scene->value); ?></td>			
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?story_id='.$scene->story_id.'&location_id='.$scene->location_id.'&scene_id='.$scene->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
					<td>&nbsp;&nbsp;</td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'delete'))).'?story_id='.$scene->story_id.'&location_id='.$scene->location_id.'&scene_id='.$scene->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
				</tr>
			<?php } ?>
			</table>
		</fieldset>
<?php } ?>
