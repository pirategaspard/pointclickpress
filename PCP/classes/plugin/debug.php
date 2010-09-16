<?php defined('SYSPATH') or die('No direct script access.');

/*
	Basic session variable assignment class for PointClickPress
 */

class plugin_debug implements ipcpplugin
{
	public function getClass()
	{
		return get_class($this);
	}
		
	public function getLabel()
	{
		return 'Debug';
	}
		
	public function getDescription()
	{
		return 'Debug Plugin for PCP';
	}
	
	public function getHooks()
	{
		return array('display_post_scene');
	}
		
	public function execute($hook_name='')
	{
		// did we pass 'debug' on the url?
		if (isset($_GET['debug']))
		{
			$session = Session::instance();						
			/* Add what ever you want to dump out of session here */			
			$story_data = $session->get('story_data',array());
			var_dump($story_data);
			
			$story = $session->get('story',array());
			$scene = $session->get('scene',array());														
			echo $story->scene_width;
			echo $story->scene_height;	
			echo('screen dimensions'.$_SESSION['screen_width'].'x'.$_SESSION['screen_height']);
		}
	}
}

?>