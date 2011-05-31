<?php defined('SYSPATH') or die('No direct script access.');
// for plugin Admin area
class Model_Admin_EventsAdmin extends Model_events
{		
	// recursive search for listenerClass files
	static function searchForListeners($dir='',$type='Interface_iPCPListener')
	{
		$listenerClasses = array(); // array to hold any listenerClass classes we find
		// get list of files from the cascading file system now that any module directories have been loaded
		$files = Kohana::list_files('classes'.DIRECTORY_SEPARATOR.$dir);
		foreach ($files as $class_name => $file)
		{
			$class_name = substr($class_name,strstr($class_name,'classes/')+strlen('classes/'));
			$class_name = preg_replace('/\.php/','',$class_name);
			$class_name = preg_replace('/[\/\\\]/','_',$class_name);
			
			ob_start(); // start output buffer otherwise class_exits will display the content of files that are not class files when it trys to autoload them
			if (class_exists($class_name))
			{
				// test class to make sure it is an ipcplistenerClass and optionally something more specific
				$listenerClass = new $class_name;				 
				if (($listenerClass instanceof Interface_iPCPListener)&&($listenerClass instanceof $type))
				{
					// add new listenerClass object to listenerClass array 
					$listenerClasses[$class_name] = $listenerClass;
				}
				else
				{
					//model_Utils_ModuleHelper::removeModulePath();
					unset($listenerClass);
				}
			}
			ob_end_clean(); // end output surpression		
		}		
		return $listenerClasses;
	}
	
	static function initalizeListenerClasses()
	{
		self::registerAllListenerClasses();
	}
	
	private static function getAllListenerClasses()
	{
		$args = self::getData();
		$r = array();
		$q = '	SELECT class,events
				FROM actiondefs
				UNION ALL
				SELECT class,events
				FROM plugins p
					INNER JOIN stories_plugins sp
					ON p.id = sp.plugin_id
					AND sp.status = 1
					AND sp.story_id = :story_id
				WHERE p.status = 1 ';		
		try
		{
			$r = DB::query(Database::SELECT,$q,TRUE)
											->param(':story_id',$args['story_id'])
											->execute()
											->as_array();
			$l = new Model_Utils_SimpleLog(APPPATH.'logs');
			$l->addMessage('Loaded '.count($r).' listeners for story: '.$args['story_id']);
		}
		catch (Exception $e)
		{
					
		}
		return $r;
	}
	
	private static function registerAllListenerClasses()
	{
		$instance = self::instance();
		$listeners = self::getAllListenerClasses();
		foreach ($listeners as $listener)
		{		
			// get array of events that this plugin will be executed on
			$events = explode(',',$listener['events']); 
			foreach($events as $event)
			{									
				$instance->addListener($event,$listener['class']);
			}			
		}
		unset($listeners);
	}
	
	static function getData()
	{
		$session = Session::instance('admin');	
		$data['id'] = $data['story_id'] = $session->get('story_id',0);
		if (isset($_REQUEST['story_id']))
		{
			$data['id'] = $data['story_id'] = $_REQUEST['story_id'];		
		}		
		return $data;
	}
}

?>
