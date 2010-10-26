<?php
	if (isset($images))
	{		
		echo($add_image_link);
?>

<!-- <a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit'))).'?image_id=0&story_id='.$story_id.'&scene_id='.$scene_id); ?>" >Add Image</a> -->	

		<fieldset>
			<legend>Scene images</legend>
			<table>
				<tr>
					<th>Id</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($images as $image) { ?>
				<tr>
					<td><?php echo($image->id); ?></td>
					<td><img src="<?php print(Kohana::$base_url.MEDIA_PATH.'/'.$image->story_id.'/'.$image->id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$image->filename); ?>" ></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit'))).'?image_id='.$image->id.'&story_id='.$story_id.'&scene_id='.$scene_id.'&itemstate_id='.$itemstate_id); ?>" >Edit</a></td>
					<td>
					<?php if (isset($assign_image_url))	{ ?>
						<a href='<?php print($assign_image_url.'?image_id='.$image->id); ?>' target="_parent" >Assign Image</a>
					<?php }	?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
<?php } 

//var_dump($_SESSION);
?>
