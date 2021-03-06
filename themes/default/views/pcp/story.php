<?php ?>
<div id="story_info">
	<h1><?php echo ($story->title); ?></h1>
	<h3>By: <?php echo ($story->author); ?></h3>	
	<img src="<?php echo (Kohana::$base_url.MEDIA_PATH.'/'.$story->id.'/'.$story->image_id.'/'.DEFAULT_SCREEN_SIZE.'/'.$story->filename); ?>" style="width: 40%;" />
	<p><?php echo ($story->short_desc); ?></p>
	
	<div id="options">
		<h3>Options:</h3>
		<p>Select Your screen size:</p>
		<form id="screen_size" method="POST" action="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'start_story'))).'?story_id='.$story->id); ?>">
			<select name="screens">
				<?php 
					foreach ($screens as $screen) 
					{ 
						echo '<option value="'.$screen['w'].'x'.$screen['h'].'">'.$screen['w'].'x'.$screen['h'].'</option>';
					} 
				?>
			</select>
			<input type="submit" name="submit" value="PLAY NOW" class="ui-widget ui-state-default ui-corner-all button save">
		</form>
	</div>
	
	<p><?php echo ($story->description); ?></p>
</div>
