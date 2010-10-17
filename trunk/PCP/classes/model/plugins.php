<?php defined('SYSPATH') or die('No direct script access.');

class Model_Plugins
{
	// Singleton static instance
	protected static $_instance;	
	protected $hooks = array(); // array to hold any plugin classes

	public static function instance()
	{
		if (self::$_instance === NULL)
		{			
			self::$_instance = new self; // Create a new instance
			self::$_instance->loadHooks(); // use the plugin cache if available
		}
		return self::$_instance;
	}
	
	// execute all plugins for a specified hook
	public static function executeHook($hook_name)
	{	
		$instance = self::instance();		
		$plugins = $instance->getPluginsByHookName($hook_name);
		foreach($plugins as $pluginclass)
		{
			$plugin = new $pluginclass();
			$plugin->execute($hook_name);
			unset($plugin);	
		}		
	}
	
	
	/* 	
		A hook is a place in PCP where a plugin can be called from such as "pre_scene"
		Each hook has an array of plugin class names that it should call when the hook is reached  
	*/
	private function registerHook($hook_name)
	{
		if (!$this->HookRegistered($hook_name))
		{
			$this->hooks[$hook_name]= array();
		}
	}
	
	// is the hook already registered?
	private function HookRegistered($hook_name)
	{
		if (isset($this->hooks[$hook_name]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// add a plugin's class name to the hook name array
	private function registerPluginHook($hook_name,$class_name)
	{
		$this->hooks[$hook_name][]= $class_name;
	}
	
	/*
		get all plugins for a specific hook 
	*/
	private function getPluginsByHookName($hook_name='')
	{
		if ($this->HookRegistered($hook_name))
		{
			$plugins = $this->hooks[$hook_name];
		}
		else
		{
			$plugins = array();
		}
		return $plugins;
	}
			
	/*
		Searches the Plugin directory for class files 
	*/
	private function loadPlugins()
	{	
		$q = '	SELECT *
				FROM plugins
				WHERE status = 1'; // only get active plugins
		$plugins = DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();
		foreach ($plugins as $plugin)
		{		
			// get array of hooks that this plugin will be executed on
			$hooks = explode(',',$plugin['hooks']); 
			foreach($hooks as $hook)
			{									
				$this->registerPluginHook($hook,$plugin['class']);
			}			
		}
		Cache::instance()->set('hooks',$this->hooks);
		unset($plugins);																		
	}
	
	private function loadHooks() 
	{
		$hooks = Cache::instance()->get('hooks',array());
		if (count($hooks) == 0 )
		{
			$this->loadPlugins();
		}
		else
		{
			$this->hooks = $hooks;
		}				
	}	
}
?>
