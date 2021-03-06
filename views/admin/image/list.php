<?php
	if (isset($images))
	{		
?>
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all" >
		<?php if (isset($add_image_link)) echo('<span class="add">'.$add_image_link."</span>"); ?>
		<legend>Scene images</legend>
		<table>
			<tr>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<?php foreach($images as $image) { ?>
			<tr>
				<td><img src="<?php print(Kohana::$base_url.MEDIA_PATH.'/'.$image->story_id.'/'.$image->id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$image->filename); ?>" ><br /><?php echo $image->filename ?></td>
				<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit'))).'?image_id='.$image->id.$url); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
				<td>
				<?php if (isset($assign_image_url))	{ ?>
					<a href='<?php print($assign_image_url.'?image_id='.$image->id.$url); ?>' target="_parent" class="ui-widget ui-state-default ui-corner-all button" >Assign Image</a>
				<?php }	?>
				</td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
<?php } 

//var_dump($_SESSION);
?>
