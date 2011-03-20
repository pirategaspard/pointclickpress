<?php defined('SYSPATH') or die('No direct script access.');

class Model_Plugins
{
	
	public static function init()
	{
		self::AddPluginEvents();
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
			
	/* adds events from plugins that are active in db */
	private static function AddPluginEvents()
	{	
		$events_instance = Events::instance();
		$q = '	SELECT *
				FROM plugins
				WHERE status = 1'; // only get active plugins
		$plugins = DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();
		foreach ($plugins as $plugin)
		{		
			// get array of events that this plugin will be executed on
			$events = explode(',',$plugin['events']); 
			foreach($events as $event)
			{									
				$events_instance->addListener($event,$plugin['class']);
			}			
		}
		unset($plugins);																		
	}
}
?>
