<?php 
	if (isset($stories))
	{	
		Events::announceEvent(ADMIN_DISPLAY_PRE_STORIES_LIST);
?>
		<fieldset class="ui-helper-reset ui-widget-content ui-corner-all">
			<?php if (isset($story_add)) echo('<span class="add">'.$story_add."</span>"); ?>
			<legend>Your Interactive Stories</legend>
			<table>
				<tr>
					<th>Title</th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				<?php foreach($stories as $story) { ?>
				<tr>
					<td><h4><?php echo($story->title); ?></h4></td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit'))).'?story_id='.$story->id); ?>" class="ui-widget ui-state-default ui-corner-all button" >Edit</a></td>
					<td><a href="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'story'))).'?story_id='.$story->id); ?>" target="_blank" class="ui-widget ui-state-default ui-corner-all button play">Play</a></td>
					<td>&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;</td>
					<td><a href="<?php echo(Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'delete'))).'?story_id='.$story->id); ?>" class="ui-widget ui-state-default ui-corner-all button delete" >Delete</a></td>
				</tr>
				<?php } ?>
			</table>
		</fieldset>
<?php } ?>