<?php defined('SYSPATH') or die('No direct script access.');
// for plugin Admin area
class Model_Admin_PluginsAdmin extends Model_Plugins
{
	static function getPlugins()
	{
		// step 1: search plugin directory and get plugins
		$plugin_files = self::searchForPlugins();
		//for each plugin that is found get installed status
		foreach ($plugin_files as $plugin)
		{
			if (!self::isInstalled($plugin->getClass()))
			{
				$plugin->install();
				self::insertPlugin($plugin);
			}
		}
		// step 2: for all plugins that are in the db, delete any that do not exist
		$plugins_installed = self::loadPlugins();		
		foreach ($plugins_installed as $plugin)
		{
			if (!array_key_exists($plugin['class'],$plugin_files))
			{
				self::deletePlugin($plugin['class']);
			}
		}
		// step 3: delete hooks cache since plugin data may have changed. 	
		//Hooks::instance()->clearHooks();
		//step 4: re-query db for all currently installed plugins
		$plugins = self::loadPlugins();	
		return $plugins;
	}
		
	static function isInstalled($class_name) 
	{
		$q_results = self::getPluginByClassName($class_name);
		if (count($q_results) > 0 )
		{				
			return true;	
		}
		else
		{
			return false;
		}
	}		
		
	static function insertPlugin($plugin) 
	{
		$q = '	INSERT INTO plugins
				(label,description,class,hooks,status)
				VALUES
				(
					:label,
					:description,
					:class,
					:hooks,
					:status
				)';
		$q_results = DB::query(Database::INSERT,$q,TRUE)
											->param(':label',$plugin->getLabel())
											->param(':description',$plugin->getDescription())
											->param(':class',$plugin->getClass())
											->param(':hooks',$plugin->getHooks())
											->param(':status',0)
											->execute();
		return true;
	}
	
	static function deletePlugin($class_name) 
	{
		$q = '	DELETE FROM plugins
				WHERE class = :class';
		$q_results = DB::query(Database::DELETE,$q,TRUE)->param(':class',$class_name)->execute();		
		return true;	
	}
	
	static function deletePluginByID($id) 
	{
		$q = '	DELETE FROM plugins
				WHERE id = :id';
		$q_results = DB::query(Database::DELETE,$q,TRUE)->param(':id',$id)->execute();		
		return true;	
	}
	
	static function updatePlugin($id,$status)
	{
		$q = '	UPDATE plugins
				SET	status = :status
				WHERE id = :id';
		$q_results = DB::query(Database::UPDATE,$q,TRUE)
										->param(':id',$id)
										->param(':status',$status)
										->execute();
		return true;
	}
	
	static function loadPlugins() 
	{
		$q = '	SELECT *
				FROM plugins';
		return DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();		
	}		
	
	static function searchForPlugins()
	{		
		$dir = 'classes/plugin/';
		$files = scandir(APPPATH.$dir);// get all the files in the plugin directory
		$plugins = array();
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
				if ($plugin instanceof Interfaces_iPCPPlugin)
				{	
					$plugins[$plugin->getClass()] = $plugin;
				}				
			}		
		}
		return $plugins;				
	}	
}
?>
