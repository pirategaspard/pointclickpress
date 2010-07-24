<?php if (isset($story)) { ?>
	<a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" target="_blank">Play <?php echo($story->title); ?></a><br />
	<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')))); ?>">Back to story list</a><br />
<?php } else { ?>
<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')))); ?>">Manage Users</a><br />
<?php } ?>

