<?php defined('SYSPATH') or die('No direct script access.');

// Holds all our plugin and hook information 

class pluginadmin
{
	// Singleton static instance
	protected static $_instance;	
	protected $plugins = array(); // array to hold any plugin classes
	
	public static function instance()
	{
		if (self::$_instance === NULL)
		{			
			self::$_instance = new self; // Create a new instance
			self::$_instance->loadPLugins();
		}
		return self::$_instance;
	}
	
	/* 	
		A hook is a place in PCP where a plugin can be called from such as "pre-scene"
		Each hook has an array of plugin class names that it should call when the hook is reached  
	*/
	function registerHook($hook_name)
	{
		if (!$this->HookRegistered($hook_name))
		{
			$this->plugins[$hook_name]= array();
		}
	}
	
	// is the hook already registered?
	function HookRegistered($hook_name)
	{
		if (isset($this->plugins[$hook_name]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// add a plugin's class name to the hook name array
	function registerPlugin($hook_name,$class_name)
	{
		$this->plugins[$hook_name][]= $class_name;
	}
	
	function getPlugins($hook_name)
	{
		if ($this->HookRegistered($hook_name))
		{
			$plugins = $this->plugins[$hook_name];
		}
		else
		{
			$plugins = array();
		}
		return $plugins;
	}
	
	// execute all plugins in a hook
	static function executeHook($hook_name)
	{	
		$instance = self::instance();		
		$plugins = $instance->getPlugins($hook_name);
		foreach($plugins as $pluginclass)
		{
			$plugin = new $pluginclass();
			$plugin->execute($hook_name);
			unset($plugin);	
		}		
	}
	
	/*
		Searches the Plugin directory for class files 
		TO DO: cache this so we don't have to scan the plugin directory per request
	*/
	private function loadPlugins()
	{		
		$dir = 'classes/plugin/';
		$files = scandir(APPPATH.$dir);// get all the files in the plugin directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			// if a file is php assume its a class 
			if ((isset($pathinfo['extension']))&&($pathinfo['extension'] == 'php'))
			{
				// add new plugin object to event array 
				$class_name = 'plugin_'.$pathinfo['filename'];
				// test class to make sure it is an ipcpplugin 
				$plugin = new $class_name;				 
				if ($plugin instanceof iPCPplugin)
				{	
					// get array of hooks that this plugin will be executed on
					$hooks = $plugin->getHooks(); 
					foreach($hooks as $hook)
					{									
						$this->registerPlugin($hook,$plugin->getClass());
					}
				}
				unset($plugin);					
			}		
		}				
	}
}
?>