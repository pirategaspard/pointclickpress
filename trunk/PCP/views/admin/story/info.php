<a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit'))).'?story_id='.$story->id); ?>"><?php echo($story->title.' by: '.$story->author); ?></a>
