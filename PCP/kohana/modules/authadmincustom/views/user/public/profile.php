<div class="ui-helper-reset ui-widget-content ui-corner-all">
   <h1><?php echo __('User profile') ?></h1>
   <div class="content">
      <h2>Username</h2>
      <p><?php echo $user->username ?></p>
      <h2>Info:</h2>
      <p><?php echo $user->info ?></p>
      <br />
      <p>Last login was <?php echo date('F jS, Y', $user->last_login) ?>, at <?php echo date('h:i:s a', $user->last_login) ?>.</p>
   </div>
</div>

<?php
	Events::announceEvent(DISPLAY_PRE_STORIES_LIST);
?>
<div id="stories" >
	<h1>Interactive Stories</h1>
	<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
		<table>
			<tr>			
				<th></th>
				<th>Title</th>
				<th>Author</th>
				<th>Description</th>
				<th></th>
			</tr>
			<?php foreach($stories as $story) { ?>
			<tr>
				<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>"><img src="<?php echo (Kohana::$base_url.MEDIA_PATH.'/'.$story->id.'/'.$story->image_id.'/'.THUMBNAIL_IMAGE_SIZE.'/'.$story->filename); ?>" /></a></td>
				<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>"><h4><?php echo($story->title); ?></h4></a></td>
				<td><a href="<?php echo(Url::site(Route::get('user')->uri(array('action'=>'userinfo'))).'?username='.$story->author); ?>"><h4><?php echo($story->author); ?></h4></a></td>
				<td><?php echo($story->description); ?></td>
				<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" class="ui-widget ui-state-default ui-corner-all button play">Play</a></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
</div>