<?php defined('SYSPATH') or die('No direct script access.');
// for plugin Admin area
class Model_Admin_EventsAdmin extends Model_events
{	
	static function registerAllListenerClasses()
	{
		$events_instance = Events::instance();
		$listeners = self::getAllListenerClasses();
		foreach ($listeners as $listener)
		{		
			// get array of events that this plugin will be executed on
			$events = explode(',',$listener['events']); 
			foreach($events as $event)
			{									
				$events_instance->addListener($event,$listener['class']);
			}			
		}
		unset($listeners);
	}
	
	// recursive search for listenerClass files
	static function searchForListeners($dir='',$type='Interface_iPCPListener')
	{
		$listenerClasses = array(); // array to hold any listenerClass classes we find
		if (is_dir($dir))
		{
			$files = scandir($dir);// get all the files in the listenerClass directory
			foreach($files as $file)
			{
				$pathinfo = pathinfo($dir.$file);
				// if a file is php assume its a class 
				if ((isset($pathinfo['extension']))&&(($pathinfo['extension']) == 'php'))
				{
					// build class name from file path
					$class_name = substr($pathinfo['dirname'],strstr($pathinfo['dirname'],APPPATH.'classes/')+strlen(APPPATH.'classes/'));
					$class_name .= '/'.$pathinfo['filename'];
					$class_name = preg_replace('/\//','_',$class_name);
					
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
							unset($listenerClass);
						}
					}
					ob_end_clean(); // end output surpression
				}
				// if this file is actually a directory and not '.' or '..': recurse 
				else if ((is_dir($dir.$file))&&(strlen($file) > 2))
				{
					$listenerClasses = array_merge($listenerClasses,self::searchForListeners($dir.$file.'/'));
				}
			}
		}
		return $listenerClasses;
	}
}

?>
