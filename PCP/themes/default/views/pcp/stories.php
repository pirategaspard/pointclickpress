<?php /*var_dump($stories); die(); */?>

<h1>Interactive Stories</h1>
<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
	<table>
		<tr>			
			<th>Title</th>
			<th>Description</th>
			<th></th>
		</tr>
		<?php foreach($stories as $story) { ?>
		<tr>
			<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>"><h4><?php echo($story->title); ?></h4></a></td>
			<td><?php echo($story->description); ?></td>
			<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" class="ui-widget ui-state-default ui-corner-all button play">Play</a></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
