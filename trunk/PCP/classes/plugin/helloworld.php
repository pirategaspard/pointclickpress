<?php defined('SYSPATH') or die('No direct script access.');
/*
	Basic session variable assignment class for PointClickPress
 */

class plugin_helloworld implements ipcpplugin
{
	public function getClass()
	{
		return get_class($this);
	}
		
	public function getLabel()
	{
		return 'helloworld';
	}
		
	public function getDescription()
	{
		return 'helloworld';
	}
	
	public function getHooks()
	{
		// You can list multiple hooks to be called from
		return array('post_start_story','display_pre_scene','display_post_scene');
	}
		
	public function execute($hook_name='')
	{						
		/*
			You are passed the hook you are currently being called from
			If you wish you can use this to decide to perform different actions
		*/
		switch($hook_name)
		{
			case 'display_pre_scene':
			{
				echo('Hello World!');
				break;
			}
			case 'display_post_scene':
			{
				include('helloworld/index.htm');
				break;
			}			
		}
		
		/* 
			You can also access session from here!
			You could add something awesome, or do some damage
		*/
		$session = Session::instance();
		
		// uncomment the code block below for secret cheat to go immediately to last scene!
		/*
		if ($hook_name == 'post_start_story')
		{
			$story_data = $session->get('story_data',array());			
			$story_data['container_id'] = 28;
			$story_data = $session->set('story_data',$story_data);
		}
		*/
					
	}
}