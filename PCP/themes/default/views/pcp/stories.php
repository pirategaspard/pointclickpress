<?php /*var_dump($stories); die(); */?>
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
				<td><?php echo($story->short_desc); ?></td>
				<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" class="ui-widget ui-state-default ui-corner-all button play">Play</a></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
</div>
