<?php if (isset($story)) { ?>
	<a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" target="_blank">Play <?php echo($story->title); ?></a><br />
<?php } ?>

