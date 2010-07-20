<a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" target="_blank">Play <?php echo($story->title); ?></a>
<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')))); ?>">Back to story list</a>
<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')))); ?>">Manage Users</a>

