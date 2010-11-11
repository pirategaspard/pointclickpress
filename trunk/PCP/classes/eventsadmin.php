<?php defined('SYSPATH') or die('No direct script access.');

class EventsAdmin
{		
	// get a single Event object and populate it based on the arguments
	static function getEvent($args=array())
	{		
		// if we have been passed a type, get that specific type of event, otherwise save a generic event	
		if (isset($args['type']))
		{
			// what kind of event are we getting? 
			switch ($args['type'])
			{	
				case 'Grid':					
					$event = EventsAdmin::getGridEvent($args);					
				break;
				case 'Scene':
					$event = EventsAdmin::getSceneEvent($args);
				break;
				case 'location':
					$event = EventsAdmin::getlocationEvent($args);
				break;
				case 'Story':
					$event = EventsAdmin::getStoryEvent($args);
				break;
				default:
					$event = new Model_Event($args);
				break;
			}
		}
		else
		{
			$event = new Model_Event($args);
		}
		return $event->load($args);
	}
	
	static function getStoryEvent($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_StoryEvent($args);
		return $event->load($args);
	}
	
	static function getLocationEvent($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_locationEvent($args);
		return $event->load($args);
	}
	
	static function getSceneEvent($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_SceneEvent($args);
		return $event->load($args);
	}
	
	static function getGridEvent($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_GridEvent($args);
		return $event->load($args);
	}
	
	static function getEvents($args=array())
	{				
		if (isset($args['scene'])) 
		{
  			$Events = EventsAdmin::getSceneEvents($args);
		}
		else if (isset($args['location'])) 
		{
  			$Events = EventsAdmin::getLocationEvents($args);
		}	
		else if (isset($args['story'])) 
		{
  			$Events = EventsAdmin::getStoryEvents($args);
		}
		return $Events;
	}
	
	static function getStoryEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.story_id
				FROM events e
				INNER JOIN stories_events b
					ON (b.event_id = e.id
					AND b.story_id = :story_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':story_id',$args['story']->id)
					->execute()
					->as_array();			
		$EventsAdmin = array();
		foreach($tempArray as $e)
		{
			$EventsAdmin[$e['id']] = EventsAdmin::getStoryEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getLocationEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.location_id
				FROM events e
				INNER JOIN locations_events b
					ON (b.event_id = e.id
					AND b.location_id = :location_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':location_id',$args['location']->id)
					->execute()
					->as_array();			
		$EventsAdmin = array();
		foreach($tempArray as $e)
		{
			$EventsAdmin[$e['id']] = EventsAdmin::getLocationEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getSceneEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.scene_id
				FROM events e
				INNER JOIN scenes_events b
					ON (b.event_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene']->id)
					->execute()
					->as_array();			
		$EventsAdmin = array();
		foreach($tempArray as $e)
		{
			$EventsAdmin[$e['id']] = EventsAdmin::getSceneEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getGridEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.grid_event_id,
						b.scene_id
				FROM events e
				INNER JOIN grids_events b
					ON (b.event_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene']->id)
					->execute()
					->as_array();			
		$EventsAdmin = array();
		foreach($tempArray as $e)
		{
			$EventsAdmin[$e['id']] = EventsAdmin::getGridEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getEventsList($args=array())
	{
		if (!isset($args['type'])) {$args['type']='';}		
		switch ($args['type'])
		{
			case 'Grid':				
				$view = View::factory('/admin/event/list_grid',$args)->render();
			break;
			default:
				$view = View::factory('/admin/event/list',$args)->render();
			break;
		}
		return $view;
	}
	
	static function getEventType()
	{
		$type = '';
		$session = Session::instance();		
		if (isset($_REQUEST['story_id'])||$session->get('story_id'))
		{
			$type = 'Story';
		}
		if (isset($_REQUEST['location_id'])||$session->get('location_id'))
		{
			$type = 'location';
		}
		if (isset($_REQUEST['scene_id'])||$session->get('scene_id'))
		{
			$type = 'Scene';
		}
		if (isset($_POST['cell_ids'])||$session->get('cell_ids'))
		{
			$type = 'Grid';
		}	
		return $type;
	} 
	
	/*
		Searches the Event directory for class files 
	*/
	static function loadEventTypes()
	{	
		$EventTypes = array();	// array to hold any event classes we find
		$dir = 'classes/event/';
		$files = scandir(APPPATH.$dir);// get all the files in the event directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'php')
			{
				// add new event object to event array 
				$class_name = 'event_'.$pathinfo['filename'];
				// test class to make sure it is an ipcpevent 
				$event = new $class_name;				 
				if ($event instanceof iPCPevent)
				{
					$EventTypes[] = $event;
				}
				else
				{
					unset($event);
				}	
			}		
		}
		return $EventTypes;		
	}

	
	/*
		Searches the js/event directory for js files
	*/
	static function loadJSEventTypes()
	{	
		$JSEventTypes = array();	// array to hold any event scripts we find
		$dir = '/js/event/';
		$files = scandir(APPPATH.$dir);// get all the files in the event directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'js')
			{
				// add new event object to event array 
				$JSEventTypes[] = 'event/'.$pathinfo['basename'];
			}			
		}		
		return $JSEventTypes;		
	}
	
	/* 
		caches js files array so that we don't rescan js/event/ on the frontend for each request
	*/ 
	static function cacheJSEventTypes()
	{		
		$JSEventTypes = self::loadJSEventTypes();
		Cache::instance()->set('js_events',$JSEventTypes);
		return $JSEventTypes; 
	}
	
}

