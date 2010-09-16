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
		return array('display_post_scene');
	}
		
	public function execute($hook_name='')
	{						
		// You can perform different actions based on which hook your are being called from
		switch($hook_name)
		{
			case 'pre_scene':
			{
				include('helloworld/index.htm');
				break;
			}
			case 'post_scene':
			{
				echo('Hello World!');
				break;
			}
		}
		
		// You can also access session from here
		$session = Session::instance();
		
		// uncomment for secret cheat to go immediately to last scene!
		/*$session = Session::instance();
		$story_data = $session->get('story_data',array());			
		$story_data['container_id'] = 28;
		$story_data = $session->set('story_data',$story_data);
		*/
					
	}
}