<h1><?php echo ($story->title); ?></h1>
<h3>By: <?php echo ($story->author); ?></h3>
<p><?php echo ($story->description); ?></p>


<a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'start_story'))).'?story_id='.$story->id); ?>">PLAY NOW</a>



