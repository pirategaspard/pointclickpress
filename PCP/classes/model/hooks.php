<?php defined('SYSPATH') or die('No direct script access.');

class Model_Hooks
{
	// Singleton static instance
	protected static $_instance;	
	protected $hooks = array(); // array to hold any classes to execute on hooks

	public static function instance()
	{
		if (self::$_instance === NULL)
		{			
			self::$_instance = new self; // Create a new instance
			//self::$_instance->loadHooks(); // get the cache if available
		}
		return self::$_instance;
	}
	
	// execute all plugins for a specified hook
	public static function executeHook($hook_name)
	{	
		$instance = self::instance();		
		$plugins = $instance->getClassesByHookName($hook_name);
		foreach($plugins as $pluginclass)
		{
			$plugin = new $pluginclass();
			$plugin->execute($hook_name);
			unset($plugin);	
		}		
	}
	
	/* 	
		A hook is a place in PCP where a class can be called from such as "pre_scene"
		Each hook has an array of class names that should be used when the hook is reached  
	*/
	public function registerHook($hook_name)
	{
		if (!$this->HookRegistered($hook_name))
		{
			$this->hooks[$hook_name]= array();
			//$this->saveHooks();
		}
	}
	
	// add a listener's class name to the hook name array
	public function registerHookClass($hook_name,$class_name)
	{
		$this->registerHook($hook_name);
		if (!$this->HookClassRegistered($hook_name,$class_name))
		{
			$this->hooks[$hook_name][$class_name]= $class_name;
			//$this->saveHooks();
		}
	}
	
	/*
		get all classes for a specific hook 
	*/
	private function getClassesByHookName($hook_name='')
	{
		if ($this->HookRegistered($hook_name))
		{
			$classes = $this->hooks[$hook_name];
		}
		else
		{
			$classes = array();
		}
		return $classes;
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
	
	// is the class already registered?
	private function HookClassRegistered($hook_name, $class_name)
	{
		if (isset($this->hooks[$hook_name][$class_name]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	private function saveHooks()
	{
		//Cache::instance()->set('hooks',$this->hooks);
	}
	
	private function loadHooks() 
	{
		$this->hooks = @Cache::instance()->get('hooks',array());				
	}	
	
	private function clearHooks()
	{
		Cache::instance()->delete('hooks');
	}*/
}
?>
