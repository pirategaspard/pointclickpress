<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Events helper file.
 * Contains functions for getting event and events and managing events in the PCP admin
 * */

class Model_Admin_EventsAdmin extends Model_PCP_Events
{		
	static function getEvents($args=array())
	{				
		if (!isset($args['event_type'])) {$args['event_type']=EVENT_TYPE_NULL;}	
		
		// what kind of event are we getting? 
		switch ($args['event_type'])
		{	
			case EVENT_TYPE_ITEMSTATE:
				$events = self::getItemStateEvents($args);
			break;
			case EVENT_TYPE_ITEMDEF:
				$events = self::getItemDefEvents($args);
			break;
			case EVENT_TYPE_GRIDITEM:
				$events = self::getGridItemEvents($args);
			break;
			case EVENT_TYPE_SCENE:
				$events = self::getSceneEvents($args);
			break;
			case EVENT_TYPE_LOCATION:
				$events = self::getLocationEvents($args);
			break;
			case EVENT_TYPE_STORY:
				$events = self::getStoryEvents($args);
			break;
			default:
				$events = array();
			break;
		}

		return $events;
	}
	
	static function getGridItemEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.griditem_id
				FROM events e
				INNER JOIN grids_items_events b
					ON (e.id = b.event_id
					AND b.griditem_id = :griditem_id)
				ORDER BY e.id DESC';

		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':griditem_id',$args['griditem_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getGriditemEvent()->init($e);
		}
		return $events;		
	}
	
	static function getEventsList($args=array())
	{
		if (!isset($args['event_type'])) {$args['event_type']=EVENT_TYPE_NULL;}		
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
		if (isset($args['story_id']))
		{
			$type = EVENT_TYPE_STORY;
		}
		if (isset($args['location_id']))
		{
			$type = EVENT_TYPE_LOCATION;
		}
		if (isset($args['scene_id']))
		{
			$type = EVENT_TYPE_SCENE;
		}
		if (isset($args['cell_ids']))
		{
			$type = EVENT_TYPE_GRID;
		}
		if (isset($args['itemdef_id']))
		{
			$type = EVENT_TYPE_ITEMDEF;
		}
		if (isset($args['itemstate_id']))
		{
			$type = EVENT_TYPE_ITEMSTATE;
		}
		if (isset($args['griditem_id']))
		{
			$type = EVENT_TYPE_GRIDITEM;
		}	
		return $type;
	} 
	
	static function getData()
	{
		$session = Session::instance();
		//Model_Admin_PCPAdmin::clearArgs();	
		$data = array();
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
		if (isset($_REQUEST['itemdef_id']))
		{
			$data['itemdef_id'] = $_REQUEST['itemdef_id'];				
		}
		else if ($session->get('itemdef_id'))
		{
			$data['itemdef_id'] = $session->get('itemdef_id');
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$data['itemstate_id'] = $_REQUEST['itemstate_id'];				
		}
		else if ($session->get('itemstate_id'))
		{
			$data['itemstate_id'] = $session->get('itemstate_id');
		}
		if (isset($_REQUEST['griditem_id']))
		{
			$data['griditem_id'] = $_REQUEST['griditem_id'];				
		}
		else if ($session->get('griditem_id'))
		{
			$data['griditem_id'] = $session->get('griditem_id');
		}
		if (isset($_REQUEST['event_id']))
		{
			$data['id'] = $data['event_id'] = $_REQUEST['event_id'];
		}
		else
		{
			$data['id'] = $data['event_id'] = 0; 
		}
		$data['event_type'] = self::getEventType($data);
		switch ($data['event_type'])
		{	
			case EVENT_TYPE_STORY:
				$data['add_id'] = 'story_id='.$data['story_id'];
			break;
			case EVENT_TYPE_LOCATION:
				$data['add_id'] = 'location_id='.$data['location_id'];
			break;
			case EVENT_TYPE_SCENE:
				$data['add_id'] = 'scene_id='.$data['scene_id'];
			break;
			case EVENT_TYPE_ITEMDEF:
				$data['add_id'] = 'itemdef_id='.$data['itemdef_id'];
			break;
			case EVENT_TYPE_ITEMSTATE:
				$data['add_id'] = 'itemstate_id='.$data['itemstate_id'];
			break;
			case EVENT_TYPE_GRIDITEM:
				$data['add_id'] = 'griditem_id='.$data['griditem_id'];
			break;
			default:
				$data['add_id'] = '';
			break;
		}
		return $data;
	}
	
	/*
		Searches the Event directory for class files 
	*/
	static function loadEventDefs($event_type=EVENT_TYPE_NULL)
	{	
		self::cacheJSEventDefs(); // cache JS event files
		$dir = 'classes/event/';
		return self::searchFilesforEventDefs(APPPATH.$dir);		
	}
	
	// recursive search for eventdef class files
	private static function searchFilesforEventDefs($dir='')
	{
		$eventtypes = array(); // array to hold any event classes we find
		$files = scandir($dir);// get all the files in the event directory

		foreach($files as $file)
		{
			$pathinfo = pathinfo($dir.$file);
			// if a file is php assume its a class 
			if ((isset($pathinfo['extension']))&&(($pathinfo['extension']) == 'php'))
			{
				$class_name = substr($pathinfo['dirname'],strstr($pathinfo['dirname'],APPPATH.'classes/')+strlen(APPPATH.'classes/'));
				$class_name .= '/'.$pathinfo['filename'];
				$class_name = preg_replace('/\//','_',$class_name);
				// test class to make sure it is an ipcpevent 
				$event = new $class_name;				 
				if ($event instanceof interfaces_iPCPevent)
				{
					// add new event object to event array 
					$eventtypes[] = $event;
				}
				else
				{
					unset($event);
				}
			}
			else if ((is_dir($dir.$file))&&(strlen($file) > 2))
			{
				$eventtypes = array_merge($eventtypes,self::searchFilesforEventDefs($dir.$file.'/'));
			}
		}
		return $eventtypes;
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

	static function loadEventTypeEventDefs($event_type=EVENT_TYPE_NULL)
	{
		$e = self::loadEventDefs();
		$eventDefs = Array();
		
		if ($event_type != EVENT_TYPE_NULL)
		{
			foreach($e as $eventDef)
			{
				if (count(array_intersect($eventDef->getAllowedTypes(),array($event_type))) > 0)
				{
					$eventDefs[] = $eventDef;
				}
			}
		}
		else
		{
			$eventDefs = $e;
		}
		return $eventDefs; // get php event classes 
	}
	
}

