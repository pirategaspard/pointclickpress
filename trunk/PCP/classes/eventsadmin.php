<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Events helper file.
 * Contains functions for getting event and events and managing events in the PCP admin
 * */

class EventsAdmin
{		
	// get a single Event object and populate it based on the arguments
	static function getEvent($args=array())
	{		
		// if we have been passed a type, get that specific type of event, otherwise save a generic event	
		if (isset($args['event_type']))
		{
			// what kind of event are we getting? 
			switch ($args['event_type'])
			{	
				case EVENT_TYPE_ITEMSTATE:					
					$event = EventsAdmin::getItemstateEvent($args);					
				break;
				case EVENT_TYPE_GRID:					
					$event = EventsAdmin::getGridEvent($args);					
				break;
				case EVENT_TYPE_SCENE:
					$event = EventsAdmin::getSceneEvent($args);
				break;
				case EVENT_TYPE_LOCATION:
					$event = EventsAdmin::getLocationEvent($args);
				break;
				case EVENT_TYPE_STORY:
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
	
	static function getItemstateEvent($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_itemstateEvent($args);
		return $event->load($args);
	}

	/* create an event */
	static function createEvent($event='',$event_value='',$type='event',$event_label='',$story_id=0)
	{
		$args = array(	'event'=>$event
				,'event_value'=>$event_value
				,'type'=>$type
				,'event_label'=>$event_label
				,'story_id'=>$story_id
				);
		$event = EventsAdmin::getEvent($args);
		return $event;
	}

	
	static function doEvent($event='',$event_value='',$type='event',$event_label='',$story_id=0)
	{
		$event = EventsAdmin::createEvent($event,$event_value,$type,$event_label,$story_id);
		$event_results = Model_Events::doEvent($event);
		return $event_results;
	}
	
	static function getEvents($args=array())
	{				
		if (!isset($args['event_type'])) {$args['event_type']=EVENT_TYPE_NULL;}	
		
		// what kind of event are we getting? 
		switch ($args['event_type'])
		{	
			case EVENT_TYPE_ITEMSTATE:
				$events = EventsAdmin::getItemstateEvents($args);
			break;
			case EVENT_TYPE_SCENE:
				$events = EventsAdmin::getSceneEvents($args);
			break;
			case EVENT_TYPE_LOCATION:
				$events = EventsAdmin::getLocationEvents($args);
			break;
			case EVENT_TYPE_STORY:
				$events = EventsAdmin::getStoryEvents($args);
			break;
			default:
				$events = array();
			break;
		}

		return $events;
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
					->param(':story_id',$args['story_id'])
					->execute()
					->as_array();			
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = EventsAdmin::getStoryEvent()->init($e);
		}
		return $events;		
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
					->param(':location_id',$args['location_id'])
					->execute()
					->as_array();			
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = EventsAdmin::getLocationEvent()->init($e);
		}
		return $events;		
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
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = EventsAdmin::getSceneEvent()->init($e);
		}
		return $events;		
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
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();			
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = EventsAdmin::getGridEvent()->init($e);
		}
		return $events;		
	}
	
	static function getItemstateEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.itemstate_id
				FROM events e
				INNER JOIN items_states_events b
					ON (e.id = b.event_id
					AND b.itemstate_id = :itemstate_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemstate_id',$args['itemstate_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = EventsAdmin::getItemstateEvent()->init($e);
		}
		return $events;		
	}
	
	static function getEventsList($args=array())
	{
		if (!isset($args['event_type'])) {$args['event_type']='';}		
		switch ($args['event_type'])
		{
			case EVENT_TYPE_GRID:				
				$view = View::factory('/admin/event/list_grid',$args)->render();
			break;
			default:
				$view = View::factory('/admin/event/list',$args)->render();
			break;
		}
		return $view;
	}
	
	static function getEventType($args=array())
	{
		$type = '';	
		$session = Session::instance();	
		if (isset($args['story_id'])||$session->get('story_id'))
		{
			$type = EVENT_TYPE_STORY;
		}
		if (isset($args['location_id'])||$session->get('location_id'))
		{
			$type = EVENT_TYPE_LOCATION;
		}
		if (isset($args['scene_id'])||$session->get('scene_id'))
		{
			$type = EVENT_TYPE_SCENE;
		}
		if (isset($_POST['cell_ids'])||$session->get('cell_ids'))
		{
			$type = EVENT_TYPE_GRID;
		}
		if (isset($_POST['itemstate_id'])||$session->get('itemstate_id'))
		{
			$type = EVENT_TYPE_ITEMSTATE;
		}	
		return $type;
	} 
	
	static function getData()
	{
		$session = Session::instance();	
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['location_id']))
		{
			$data['location_id'] = $_REQUEST['location_id'];	
		}
		else if ($session->get('location_id'))
		{
			$data['location_id'] = $session->get('location_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];				
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$data['itemstate_id'] = $_REQUEST['itemstate_id'];				
		}
		else if ($session->get('itemstate_id'))
		{
			$data['itemstate_id'] = $session->get('itemstate_id');
		}
		$data['event_type'] = self::getEventType($data);
		return $data;
	}
	
	/*
		Searches the Event directory for class files 
	*/
	static function loadEventDefs($event_type='')
	{	
		$EventTypes = array();	// array to hold any event classes we find
		$dir = 'classes/event/';
		/*if (strlen($event_type) > 0)
		{
			$dir .= $event_type.'/';
		}*/
		$files = scandir(APPPATH.$dir);// get all the files in the event directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			
			
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'php')
			{
				$class_name = 'event_';
				/*if (strlen($event_type) > 0)
				{
					$class_name .= $event_type.'_';
				}*/
				$class_name .= $pathinfo['filename'];
				// test class to make sure it is an ipcpevent 
				$event = new $class_name;				 
				if ($event instanceof iPCPevent)
				{
					// add new event object to event array 
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
	static function loadJSEventDefs()
	{	
		$JSEventDefs = array();	// array to hold any event scripts we find
		$dir = '/js/event/';
		$files = scandir(APPPATH.$dir);// get all the files in the event directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.$dir.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'js')
			{
				// add new event object to event array 
				$JSEventDefs[] = 'event/'.$pathinfo['basename'];
			}			
		}		
		return $JSEventDefs;		
	}
	
	/* 
		caches js files array so that we don't rescan js/event/ on the frontend for each request
	*/ 
	static function cacheJSEventDefs()
	{		
		$JSEventDefs = self::loadJSEventDefs();
		Cache::instance()->set('js_event_defs',$JSEventDefs);
		return $JSEventDefs; 
	}
	
}

