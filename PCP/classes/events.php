<?php defined('SYSPATH') or die('No direct script access.');

class Events
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
					$event = Events::getGridEvent($args);
				break;
				case 'Scene':
					$event = Events::getSceneEvent($args);
				break;
				case 'Container':
					$event = Events::getContainerEvent($args);
				break;
				case 'Story':
					$event = Events::getStoryEvent($args);
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
	
	static function getEvents($args=array())
	{				
		if (isset($args['scene'])) 
		{
  			$events = Events::getSceneEvents($args);
		}
		else if (isset($args['container'])) 
		{
  			$events = Events::getContainerEvents($args);
		}	
		else if (isset($args['story'])) 
		{
  			$events = Events::getStoryEvents($args);
		}
		return $events;
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
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = Events::getEvent()->init($e);
		}
		return $events;		
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
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = Events::getEvent()->init($e);
		}
		return $events;		
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
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = Events::getEvent()->init($e);
		}
		return $events;		
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
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = Events::getEvent()->init($e);
		}
		return $events;		
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
		Searches the events directory for class files
	*/
	static function getEventTypes($args=array())
	{	
		$events = array();	// array to hold any event classes we find
		$files = scandir(APPPATH.'classes/event/');// get all the files in the event directory
		foreach($files as $file)
		{
			$pathinfo = pathinfo(APPPATH.'classes/event/'.$file);
			// if a file is php assume its a class 
			if (($pathinfo['extension']) == 'php')
			{
				// add new event object to event array 
				$class_name = 'event_'.$pathinfo['filename'];
				$events[] = new $class_name;
			}			
		}
		return $events;		
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doEvents($events)
	{
		$event_occured = 0;
		// get session 
		$session = Session::instance();
		//get story_data from session. This is the info events are allowed to manipulate
		$story_data = $session->get('story_data',array());
		foreach($events as $event)
		{
			// 'event' is the class name			
			$class_name = $event['event'];
			// get the class
			$event_class = new $class_name; 
			//execute event. Events can directly manipulate session's "story_data" info
			$event_occured = $event_class->execute(array('event_value'=>$event['event_value']),$story_data);
			//var_dump($story_data);
		}
		//update session
		$session->set('story_data',$story_data); 
		return $event_occured;		
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doEvent($event)
	{
		$event_occured = 0;
		// get session 
		$session = Session::instance();
		//get story_data from session. This is the info events are allowed to manipulate
		$story_data = $session->get('story_data',array());			
		// 'event' is the class name			
		$class_name = $event->event;
		// get the class
		$event_class = new $class_name; 
		//execute event. Events can directly manipulate session's "story_data" info
		$event_occured = $event_class->execute(array('event_value'=>$event->event_value),$story_data);
		//update session
		$session->set('story_data',$story_data); 
		return $event_occured;		
	}

	static function isVariable($var)
	{
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9_]+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	static function isVariableOrNumeric($var)
	{
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	static function isVariableOrNumericOrString($var)
	{
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+)|(\'\w.*\'+)|("\w.*"+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	static function isString($var)
	{
		if (preg_match('/^((\'\w.*\'+)|("\w.*"+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	static function isNumeric($var)
	{
		if (preg_match('/^(([0-9]+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	// given "$myvariable" returns "myvariable"
	static function getVariableName($var)
	{
		return preg_replace('[\$| ]','',$var);
	}
	
	// given "$myvariable" returns "myvariable"
	static function replaceSessionVariables($expression)
	{
		/* 
			replace any variables with their session global equivalents 
			in order to be able to reference variables in session['data']. 
		*/	
		return preg_replace('/(\$(\w+\b))/',"\$session['data']['$2']",$expression);
	}
	
	// given 1 + 1 will return '+' or 1 < 2 returns '<'
	static function getOperators($expression)
	{
		$operators = array();
		if (preg_match('/[<=|>=|<>|!=|==|<|>|+|-|//|*|%]/',$expression, $ops))
		{
			$operators = $ops;
		}
		return $operators;
	}
	
	static function getOperator($expression)
	{
		$operator = null;
		$operators = $this->getOperators($expression);
		if (count($operators)>0)
		{
			$operator = $operators[0];
		}
		return $operator;
	}	
}

?>
