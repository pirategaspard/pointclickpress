<?php 
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
	
	public function getHook()
	{
		return 'post_scene';
	}
		
	public function execute(&$args=array())
	{
		echo('Hello World Too!');
	}
}