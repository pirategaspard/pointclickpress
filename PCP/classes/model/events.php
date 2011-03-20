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
			//self::$_instance->loadEvents(); // get the cache if available
		}
		return self::$_instance;
	}
	
	// execute all plugins for a specified event
	public static function announceEvent($event_name)
	{	
		$instance = self::instance();		
		$plugins = $instance->getClassesByEventName($event_name);
		foreach($plugins as $pluginclass)
		{
			$plugin = new $pluginclass();
			$plugin->execute($event_name);
			unset($plugin);	
		}		
	}
	
	/* 	
		A event is a place in PCP where a class can be called from such as "pre_scene"
		Each event has an array of class names that should be used when the event is reached  
	*/
	public function registerEvent($event_name)
	{
		if (!$this->EventRegistered($event_name))
		{
			$this->events[$event_name]= array();
			//$this->saveEvents();
		}
	}
	
	// add a listener's class name to the event name array
	public function registerEventClass($event_name,$class_name)
	{
		$this->registerEvent($event_name);
		if (!$this->EventClassRegistered($event_name,$class_name))
		{
			$this->events[$event_name][$class_name]= $class_name;
			//$this->saveEvents();
		}
	}
	
	/*
		get all classes for a specific event 
	*/
	private function getClassesByEventName($event_name='')
	{
		if ($this->EventRegistered($event_name))
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
	private function EventRegistered($event_name)
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
	private function EventClassRegistered($event_name, $class_name)
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
	
	/*
	private function saveEvents()
	{
		//Cache::instance()->set('events',$this->events);
	}
	
	private function loadEvents() 
	{
		$this->events = @Cache::instance()->get('events',array());				
	}	
	
	private function clearEvents()
	{
		Cache::instance()->delete('events');
	}*/
}
?>
