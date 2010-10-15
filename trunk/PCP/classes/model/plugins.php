<?php defined('SYSPATH') or die('No direct script access.');

class Model_Plugins extends pluginadmin
{
	public static function instance()
	{
		if (self::$_instance === NULL)
		{			
			self::$_instance = new self; // Create a new instance
			Cache::instance()->get('plugins',self::$_instance->cachePlugins()); // use the plugin cache if available
		}
		return self::$_instance;
	}
		
}
?>
