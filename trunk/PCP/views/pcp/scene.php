<?php 
	
	$plugins = Plugins::getPlugins();
    $sceneplugins = $plugins['pre_scene'];
    foreach ($sceneplugins as $pluginclass)
    {
    	$plugin = new $pluginclass;
		$plugin->execute();
	}
?>

<?php 

if (isset($_GET['debug']))
{
	var_dump($_SESSION['story_data']);
}
/*
	
	echo $story->scene_width;
	echo $story->scene_height;
*/
	//var_dump($scene->init_vars);	
	//echo('screen dimensions'.$_SESSION['screen_width'].'x'.$_SESSION['screen_height']);
?>
<div id="scene">
	<h1 id="title"><?php echo($scene->title); ?></h1>
	<?php echo($grid); ?>
	<p id="description"><?php echo($scene->description); ?></p>
</div>


<?php 
	
	$plugins = Plugins::getPlugins();
    $sceneplugins = $plugins['post_scene'];
    foreach ($sceneplugins as $pluginclass)
    {
    	$plugin = new $pluginclass;
		$plugin->execute();
	}
?>