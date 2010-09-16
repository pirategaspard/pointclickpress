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
		return array('display_pre_scene');
	}
		
	public function execute($hook_name='')
	{
		
		// uncomment for the secret cheat to go immediately to last scene!
		/*$session = Session::instance();
		$story_data = $session->get('story_data',array());			
		$story_data['container_id'] = 28;
		$story_data = $session->set('story_data',$story_data);
		*/			
		echo('Hello World!<br/>');
	}
}