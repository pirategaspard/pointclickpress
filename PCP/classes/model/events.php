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
		//self::registerAllListenerClasses();
	}
	
	private static function getAllListenerClasses()
	{
		$q = '	SELECT class,events
				FROM actiondefs
				UNION ALL
				SELECT class,events
				FROM plugins
				WHERE status = 1'; // only active plugins
		return DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();
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
}
?>
