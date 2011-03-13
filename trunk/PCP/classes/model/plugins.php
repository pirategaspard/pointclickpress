<?php defined('SYSPATH') or die('No direct script access.');

class Model_Plugins
{
	
	public static function init()
	{
		self::AddPluginHooks();
	}
	
	static function getPlugin($args=array())
	{
		if (isset($args['plugin']))
		{
			$p = self::getPluginByClassName($args['plugin']);
		}
		else
		{
			$p = array();
		}
		return $p;
	}
	
	static function getPluginByClassName($class_name)
	{
		$q = '	SELECT *
				FROM plugins
				WHERE class = :class';
		return DB::query(Database::SELECT,$q,TRUE)
										->param(':class',$class_name)										
										->execute()
										->as_array();	
	}
			
	/* adds hooks from plugins that are active in db */
	private static function AddPluginHooks()
	{	
		$hooks_instance = Hooks::instance();
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
				$hooks_instance->registerHookClass($hook,$plugin['class']);
			}			
		}
		unset($plugins);																		
	}
}
?>
