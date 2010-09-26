<?php 
	$screens = Screens::getScreens();
?>

<h1><?php echo ($story->title); ?></h1>
<h3>By: <?php echo ($story->author); ?></h3>
<p><?php echo ($story->description); ?></p>

<div id="options">
	<h3>Options:</h3>
	<p>Select Your screen size:</p>
	<form id="screen_size" method="POST" action="<?php echo(Url::site(Route::get('default')->uri(array('action'=>'start_story'))).'?story_id='.$story->id); ?>">
		<select name="screens">
			<?php 
				foreach ($screens as $screen) 
				{ 
					echo '<option value="'.$screen['w'].'x'.$screen['h'].'">'.$screen['w'].'x'.$screen['h'].'</option>';
				} 
			?>
		</select>
		<input type="submit" name="submit" value="PLAY NOW">
	</form>
</div>