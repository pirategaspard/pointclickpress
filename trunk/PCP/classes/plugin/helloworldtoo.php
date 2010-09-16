<?php defined('SYSPATH') or die('No direct script access.');
/*
	Basic session variable assignment class for PointClickPress
 */

class plugin_helloworldtoo implements ipcpplugin
{
	public function getClass()
	{
		return get_class($this);
	}
		
	public function getLabel()
	{
		return 'helloworldtoo';
	}
		
	public function getDescription()
	{
		return 'helloworldtoo';
	}
	
	public function getHooks()
	{
		return array('display_pre_scene','display_post_scene');
	}
		
	public function execute($hook_name='')
	{
		switch($hook_name)
		{
			case 'pre_scene':
			{
				include('helloworldtoo/index.htm');
				break;
			}
			case 'post_scene':
			{
				echo('Hello World Too!');
				break;
			}
		}
		
	}
}