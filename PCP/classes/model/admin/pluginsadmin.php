<?php defined('SYSPATH') or die('No direct script access.');
// for plugin Admin area
class Model_Admin_PluginsAdmin extends Model_Plugins
{
	static function searchForListeners()
	{
		// step 1: search plugin directory and get plugins
		$classes_found = self::search();
		//for each plugin that is found get installed status
		foreach ($classes_found as $class)
		{
			if (!self::isInstalled($class->getClass()))
			{
				$class->install(); // install plugin
				self::insert($class);
			}
		}
		// step 2: for all plugins that are in the db, delete any that do not exist
		$classes_installed = self::load();		
		foreach ($classes_installed as $class)
		{
			if (!array_key_exists($class['class'],$classes_found))
			{
				self::deleteByClassName($class['class']);
			}
		}
		// step 3: delete events cache since plugin data may have changed. 	
		//Events::instance()->clearEvents();
		//step 4: re-query db for all currently installed plugins
		$classes_installed = self::load();	
		return $classes_installed;
	}
		
	static function isInstalled($class_name) 
	{
		$q_results = self::getByClassName($class_name);
		if (count($q_results) > 0 )
		{				
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	static function uninstall($id)
	{
		$plugin = self::getByID($id);
		$p = new $plugin['class'];
		$p->uninstall(); // uninstall plugin
		unset($p);
		return self::deleteByID($id);
	}
		
	static function insert($class) 
	{
		$q = '	INSERT INTO plugins
				(label,description,class,events,status)
				VALUES
				(
					:label,
					:description,
					:class,
					:events,
					:status
				)';
		$q_results = DB::query(Database::INSERT,$q,TRUE)
											->param(':label',$class->getLabel())
											->param(':description',$class->getDescription())
											->param(':class',$class->getClass())
											->param(':events',implode(',',$class->getEvents()))
											->param(':status',0)
											->execute();
		return true;
	}
	
	static function deleteByClassName($class_name) 
	{
		$q = '	DELETE FROM plugins
				WHERE class = :class';
		$q_results = DB::query(Database::DELETE,$q,TRUE)->param(':class',$class_name)->execute();		
		return true;	
	}
	
	static function deleteByID($id) 
	{
		$q = '	DELETE FROM plugins
				WHERE id = :id';
		$q_results = DB::query(Database::DELETE,$q,TRUE)->param(':id',$id)->execute();		
		return true;	
	}
	
	static function update($id,$status)
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
	
	static function load() 
	{
		$q = '	SELECT *
				FROM plugins';
		return DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();		
	}	
	
	// recursive search for actiondef class files
	private static function search()
	{
		$dir = 'classes/plugin/';
		return Model_Admin_EventsAdmin::searchForListeners(APPPATH.$dir,'Interface_iPCPPlugin');	
	}
}
?>
