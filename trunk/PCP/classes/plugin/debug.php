<?php defined('SYSPATH') or die('No direct script access.');

/*
	Basic debuging plugin for PointClickPress
 */

class Plugin_Debug implements Interfaces_iPCPPlugin
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
	
	public function install()
	{
		// we have nothing to install
		return true;
	}
	
	public function getHooks()
	{
		return 'display_post_scene,error';
	}
		
	public function execute($hook_name='')
	{
		// did we pass 'debug' on the url?
		if (isset($_GET['debug']))
		{
			$session = Session::instance();	
								
			/* Add what ever you want to dump out of session here */			
			$story_data = $session->get('story_data',array());
			?>
			<pre>
				<?php var_dump($story_data);?>
			</pre>
			
			<style>
				#grid a {margin: -1px; padding: -1px; border: 1px solid red; }
			</style> 
			
			<?php
			
			if($hook_name == 'error')
			{
				//die();
			}
			
			/*
			$story = $session->get('story',array());
			$scene = $session->get('scene',array());														
			echo $story->scene_width;
			echo $story->scene_height;	
			echo('screen dimensions'.$_SESSION['screen_width'].'x'.$_SESSION['screen_height']);
			*/
		}
	}
}

?>
