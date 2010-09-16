<?php 
	$plugins = pluginadmin::instance();
	$plugins->executeHook('pre_scene');
?>

<?php 

if (isset($_GET['debug']))
{
	var_dump($_SESSION['story_data']);		
	echo $story->scene_width;
	echo $story->scene_height;
	var_dump($scene->init_vars);	
	echo('screen dimensions'.$_SESSION['screen_width'].'x'.$_SESSION['screen_height']);
}
?>
<div id="scene">
	<h1 id="title"><?php echo($scene->title); ?></h1>
	<?php echo($grid); ?>
	<p id="description"><?php echo($scene->description); ?></p>
</div>


<?php 
	$plugins->executeHook('post_scene');
?>