<?php defined('SYSPATH') or die('No direct script access.');

class Plugins
{
	/*
		Searches the Event directory for class files 
	*/
	static function getPlugins()
	{	
		$Plugins = array();	// array to hold any plugin classes we find
		$dir = 'classes/plugin/';
		$files = scandir(APPPATH.$dir);// get all the files in the plugin directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'php')
			{
				// add new plugin object to event array 
				$class_name = 'plugin_'.$pathinfo['filename'];
				// test class to make sure it is an ipcpplugin 
				$plugin = new $class_name;				 
				if ($plugin instanceof iPCPplugin)
				{					
					$Plugins[$plugin->getHook()][] = $plugin->getClass();
				}
				unset($plugin);					
			}		
		}
		return $Plugins;		
	}
}
?>