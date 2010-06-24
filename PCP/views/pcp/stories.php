<fieldset>
	<legend>Interactive Stories</legend>
	<table>
		<tr>			
			<th>Title</th>
			<th>Description</th>
		</tr>
		<?php foreach($stories as $story) { ?>
		<tr>
			<td>
				<a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>"><?php echo($story->title); ?></a>
			</td>
			<td><?php echo($story->description); ?></td>
		</tr>
		<?php } ?>
	</table>
</fieldset>
