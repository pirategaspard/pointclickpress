<?php defined('SYSPATH') or die('No direct script access.');

class Model_Events
{
	// Singleton static instance
	protected static $_instance;	
	protected $events = array(); // array to hold any classes to execute on events

	public static function instance()
	{
		if (self::$_instance === NULL)
		{			
			self::$_instance = new self; // Create a new instance
		}
		return self::$_instance;
	}
	
	// execute all classes for a specified event
	public static function announceEvent($event_name)
	{	
		$instance = self::instance();		
		$classes = $instance->getListenerClasses($event_name);						
		foreach($classes as $class)
		{
			$c = new $class();			
			if ($c instanceof Interface_iPCPListener)
			{ 
				$c->execute($event_name);
			}
			else
			{
				throw new Kohana_Exception($class_name . ' is not of type iPCPListener.');
			}
			unset($c);	
		}		
	}
	
	/* 	
		A event is a place in PCP where a class can be called from such as "pre_scene"
		Each event has an array of class names that should be used when the event is reached  
	*/
	public function registerEvent($event_name)
	{
		if (!$this->IsEventRegistered($event_name))
		{
			$this->events[$event_name]= array();
		}
	}
	
	// add a listener's class name to the event name array
	public function addListener($event_name,$class_name)
	{
		$this->registerEvent($event_name);
		if (!$this->IsListenerRegistered($event_name,$class_name))
		{
			$this->events[$event_name][$class_name]= $class_name;
		}
	}
	
	/*
		get all classes for a specific event 
	*/
	private function getListenerClasses($event_name='')
	{
		if ($this->IsEventRegistered($event_name))
		{
			$classes = $this->events[$event_name];
		}
		else
		{
			$classes = array();
		}
		return $classes;
	}
	
	// is the event already registered?
	private function IsEventRegistered($event_name)
	{
		if (isset($this->events[$event_name]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// is the class already registered?
	private function IsListenerRegistered($event_name, $class_name)
	{
		if (isset($this->events[$event_name][$class_name]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	static function initalizeListenerClasses()
	{
		self::registerAllListenerClasses();
	}
	
	private static function getAllListenerClasses()
	{
		$args = self::getData();
		$r = array();
		// select all registered actiondefs
		// select all plugins that are active for the system
		// select all plugins that are active for the current story		
		$q = '	SELECT class,events
				FROM actiondefs
				UNION ALL
				SELECT class,events
				FROM plugins p
				WHERE p.status = 1 
					AND p.system = 1 
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
		$session = Session::instance();	
		$data['id'] = $data['story_id'] = $session->get('story_id',0);
		if (isset($_REQUEST['story_id']))
		{
			$data['id'] = $data['story_id'] = $_REQUEST['story_id'];		
		}		
		return $data;
	}

}
?>
