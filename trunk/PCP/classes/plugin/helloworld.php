<?php 
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
	
	public function getHook()
	{
		return 'pre_scene';
	}
		
	public function execute(&$args=array())
	{
		echo('Hello World!');
	}
}