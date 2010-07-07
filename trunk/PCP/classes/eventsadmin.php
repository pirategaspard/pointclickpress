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
				case 'Container':
					$event = EventsAdmin::getContainerEvent($args);
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
	
	static function getContainerEvent($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_ContainerEvent($args);
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
	
	static function getEventsAdmin($args=array())
	{				
		if (isset($args['scene'])) 
		{
  			$EventsAdmin = EventsAdmin::getSceneEventsAdmin($args);
		}
		else if (isset($args['container'])) 
		{
  			$EventsAdmin = EventsAdmin::getContainerEventsAdmin($args);
		}	
		else if (isset($args['story'])) 
		{
  			$EventsAdmin = EventsAdmin::getStoryEventsAdmin($args);
		}
		return $EventsAdmin;
	}
	
	static function getStoryEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value
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
			$EventsAdmin[$e['id']] = EventsAdmin::getEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getContainerEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value
				FROM events e
				INNER JOIN containers_events b
					ON (b.event_id = e.id
					AND b.container_id = :container_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':container_id',$args['container']->id)
					->execute()
					->as_array();			
		$EventsAdmin = array();
		foreach($tempArray as $e)
		{
			$EventsAdmin[$e['id']] = EventsAdmin::getEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getSceneEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value
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
			$EventsAdmin[$e['id']] = EventsAdmin::getEvent()->init($e);
		}
		return $EventsAdmin;		
	}
	
	static function getGridEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value
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
			$EventsAdmin[$e['id']] = EventsAdmin::getEvent()->init($e);
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
	
	static function getUrlParams()
	{
		$data['url_params'] = '';
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
			$data['url_params'] .= '&story_id='.$_REQUEST['story_id'];
			$data['type'] = 'Story';
		}
		if (isset($_REQUEST['container_id']))
		{
			$data['container_id'] = $_REQUEST['container_id'];
			$data['url_params'] .= '&container_id='.$_REQUEST['container_id'];
			$data['type'] = 'Container';
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];
			$data['url_params'] .= '&scene_id='.$_REQUEST['scene_id'];
			$data['type'] = 'Scene';
		}
		if (isset($_POST['cell_ids']))
		{
			$data['type'] = 'Grid';
		}	
		return $data;
	}
	
	/*
		Searches the EventsAdmin directory for class files
	*/
	static function getEventTypes($args=array())
	{	
		$EventsAdmin = array();	// array to hold any event classes we find
		$files = scandir(APPPATH.'classes/event/');// get all the files in the event directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.'classes/event/'.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'php')
			{
				// add new event object to event array 
				$class_name = 'event_'.$pathinfo['filename'];
				$EventsAdmin[] = new $class_name;
			}			
		}
		return $EventsAdmin;		
	}
}
