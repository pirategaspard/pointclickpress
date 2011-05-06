<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * 
 * */

class Model_Admin_ActionDefsAdmin extends Model
{	
	static function searchForListeners()
	{
		// step 1: search directory and get classes
		$classes_found = self::search();
		//for each class that is found get installed status
		foreach ($classes_found as $class)
		{
			if (!self::isInstalled($class->getClass()))
			{
				self::insert($class);
			}
		}
		// step 2: for all classes that are in the db, delete any that do not exist
		$classes_installed = self::load();		
		foreach ($classes_installed as $class)
		{
			if (!array_key_exists($class->getClass(),$classes_found))
			{
				self::deleteByClassName($class->getClass());
			}
		}
		// step 3: delete events cache since data may have changed. 	
		//Events::instance()->clearEvents();
		//step 4: re-query db for all currently installed classes
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
	
	static function getByID($id) 
	{
		$q = '	SELECT *
				FROM actiondefs
				WHERE id = :id';
		return DB::query(Database::SELECT,$q,TRUE)->param(':id',$id)->execute()->as_array();
	}
	
	static function getByClassName($class_name)
	{
		$q = '	SELECT *
				FROM actiondefs
				WHERE class = :class';
		return DB::query(Database::SELECT,$q,TRUE)
										->param(':class',$class_name)										
										->execute()
										->as_array();	
	}
		
	static function insert($class) 
	{
		$q = '	INSERT INTO actiondefs
				(label,description,class,events,types)
				VALUES
				(
					:label,
					:description,
					:class,
					:events,
					:types
				)';
		$q_results = DB::query(Database::INSERT,$q,TRUE)
											->param(':label',$class->getLabel())
											->param(':description',$class->getDescription())
											->param(':class',$class->getClass())
											->param(':events',implode(',',$class->getEvents()))
											->param(':types',implode(',',$class->getAllowedActionTypes()))
											->execute();
		return true;
	}
	
	static function deleteByClassName($class_name) 
	{
		$q = '	DELETE FROM actiondefs
				WHERE class = :class';
		$q_results = DB::query(Database::DELETE,$q,TRUE)->param(':class',$class_name)->execute();		
		return true;	
	}
	
	static function deleteByID($id) 
	{
		$q = '	DELETE FROM actiondefs
				WHERE id = :id';
		$q_results = DB::query(Database::DELETE,$q,TRUE)->param(':id',$id)->execute();		
		return true;	
	}
	
	static function load() 
	{
		$actionDefs = array();
		$q = '	SELECT *
				FROM actiondefs';
		$results = DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();
		foreach($results as $result)
		{
			$actionDefs[] = new $result['class'];
		}
		return $actionDefs;
	}
	
	// recursive search for actiondef class files
	private static function search()
	{
		$dir = 'action';
		return Model_Admin_EventsAdmin::searchForListeners($dir,'Interface_iPCPActionDef');	
	}
	
	static function loadActionTypeActions($action_type=ACTION_TYPE_NULL)
	{
		$a = self::load();
		$actionDefs = Array();
		
		if ($action_type != ACTION_TYPE_NULL)
		{
			foreach($a as $actionDef)
			{
				if (count(array_intersect($actionDef->getAllowedActionTypes(),array($action_type))) > 0)
				{
					$actionDefs[] = $actionDef;
				}
			}
		}
		else
		{
			$actionDefs = $a;
		}
		return $actionDefs; // get php action classes 
	}
	
	/*
		Searches the js/action directory for js files
	*/
	static function loadJSActionDefs()
	{	
		$JSActionDefs = array();	// array to hold any action scripts we find
		$dir = '/js/action/';
		$files = scandir(APPPATH.$dir);// get all the files in the action directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'js')
			{
				// add new action object to action array 
				$JSActionDefs[] = 'action/'.$pathinfo['basename'];
			}			
		}		
		return $JSActionDefs;		
	}
	
	/* 
		caches js files array so that we don't rescan js/action/ on the frontend for each request
	*/ 
	static function cacheJSActionDefs()
	{		
		$JSActionDefs = self::loadJSActionDefs();
		Cache::instance()->set('js_action_defs',$JSActionDefs);
		return $JSActionDefs; 
	}
	
}
?>
