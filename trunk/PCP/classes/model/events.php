<?php defined('SYSPATH') or die('No direct script access.');

/*
		Frontend events helper class. 
*/

class Model_Events
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
				case EVENT_TYPE_ITEMDEF:					
					$event = self::getItemDefEvent($args);					
				break;
				case EVENT_TYPE_ITEMSTATE:					
					$event = self::getItemStateEvent($args);					
				break;
				case EVENT_TYPE_GRIDITEM:					
					$event = self::getGridItemEvent($args);					
				break;
				case EVENT_TYPE_GRID:					
					$event = self::getGridEvent($args);					
				break;
				case EVENT_TYPE_SCENE:
					$event = self::getSceneEvent($args);
				break;
				case EVENT_TYPE_LOCATION:
					$event = self::getLocationEvent($args);
				break;
				case EVENT_TYPE_STORY:
					$event = self::getStoryEvent($args);
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
	
	static function getItemDefEvent($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_itemdefEvent($args);
		return $event->load($args);
	}
	
	static function getItemStateEvent($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_itemstateEvent($args);
		return $event->load($args);
	}
	
	static function getGridItemEvent($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_GriditemEvent($args);
		return $event->load($args);
	}
	
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
			$events[$e['id']] = self::getStoryEvent()->init($e);
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
			$events[$e['id']] = self::getLocationEvent()->init($e);
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
			$events[$e['id']] = self::getSceneEvent()->init($e);
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
			$events[$e['id']] = self::getGridEvent()->init($e);
		}
		return $events;		
	}
	
	static function getItemDefEvents($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value,
						b.itemdef_id
				FROM events e
				INNER JOIN items_defs_events b
					ON (e.id = b.event_id
					AND b.itemdef_id = :itemdef_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemdef_id',$args['itemdef_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getItemStateEvent()->init($e);
		}
		return $events;		
	}
	
	static function getItemStateEvents($args=array())
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
			$events[$e['id']] = self::getItemstateEvent()->init($e);
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
				INNER JOIN grids_items gi
					ON (b.griditem_id = gi.id
					AND gi.scene_id = :scene_id)
				ORDER BY e.id DESC';

		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':griditem_id',$args['griditem_id'])
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getGriditemEvent()->init($e);
		}
		return $events;		
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
		$event = self::getEvent($args);
		return $event;
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doEvents($events)
	{
		$event_results = array();
		// get session 
		$session = Session::instance();
		//get story_data from session. This is the info events are allowed to manipulate
		$story_data = $session->get('story_data',array());
		foreach($events as $event)
		{
			// 'event' is the class name			
			$class_name = $event->event;
			// get the class
			$event_obj = new $class_name; 
			if ($event_obj instanceof iPCPevent)
			{
				// execute event. Events manipulate session's "story_data" info
				$event_results = array_merge($event_results,$event_obj->execute(array('event_value'=>$event->event_value),$story_data));
				//$event_results = $event_class->execute(array('event_value'=>$event->event_value),$story_data);
			}
			else
			{
				throw new Kohana_Exception($class_name . ' is not of type iPCPEvent.');
			}
		}
		//update session
		$session->set('story_data',$story_data); 
		return $event_results;		
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doEvent($event)
	{	
		$events[] = $event;
		return self::doEvents($events);							
	}
	
	// creates an event and then does it, useful when programming custom events with eval()
	static function makeEvent($event='',$event_value='',$type='event',$event_label='',$story_id=0)
	{
		$event = self::createEvent($event,$event_value,$type,$event_label,$story_id);
		$event_results = self::doEvent($event);
		return $event_results;
	}
	
	static function getJSEventDefs()
	{	
		return Cache::instance()->get('js_event_defs',EventsAdmin::cacheJSEventDefs());
	}


	/* Library functions for use in event objects */

	static function Tokenize($value,$char = ';')
	{
		// explode on semi-colon if there is more than one statement here 
		// then filter out any null or empty strings
		return array_values(array_filter(explode($char,$value))); 
	}

	// Regex used for parsing expressions in the event classes
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
		if (preg_match('/^((\'\w.*\'+)|("\w.*"+)|(\'\'+)|(""+))$/',$var))
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
	
	// given "$myvariable" returns "$session['data']['myvariable']"
	static function replaceSessionVariables($expression)
	{
		/* 
			replace any variables with their session global equivalents 
			in order to be able to reference variables in session['data']. 
		*/	
		return preg_replace('/(\$(\w+\b))/',"\$session['data']['$2']",$expression);
	}
	
	// given "$myvariable" returns "$story_data['myvariable']"
	static function replaceStoryDataVariables($expression)
	{
		/* 
			replace any variables with their $story_data equivalents 
			in order to be able to reference variables in $story_data. 
		*/	
		return preg_replace('/(\$(\w+\b))/',"\$story_data['$2']",$expression);
	}
	
	// given the string '"$myvariable"' returns 'myvariable'
	static function removeQuotes($var)
	{
		return preg_replace('/[\'"]/','',$var);
	}
	
	// if key exists in array return the value, otherwise just returns the key. 
	// Useful for getting a value out of Story_data array if it exists as a variable. 
	static function getValueFromArray($key,$thisArray)
	{
		if (isset($thisArray[$key]))
		{
			return $thisArray[$key];
		}
		else
		{
			return $key;
		}
	}
	
	// given 1 + 1 will return '+' or 1 < 2 returns '<'
	static function getOperators($expression)
	{
		$operators = array();
		if (preg_match('/strcmp|[===|<=|>=|<>|!=|==|<|>|+|-|\/|*|%]/',$expression, $ops))
		{
			$operators = $ops;
		}
		return $operators;
	}
	
	static function getOperator($expression)
	{
		$operator = null;
		$operators = Events::getOperators($expression);
		if (count($operators)>0)
		{
			$operator = $operators[0];
		}
		return $operator;
	}
	
	static function doBasicMath($val1,$operator,$val2)
	{
		$results = 0;
		switch ($operator)
		{
			case '+':
				$results = ($val1 + $val2); 
			break;
			case '-':
				$results = ($val1 - $val2); 
			break;
			case '/':
				$results = ($val1 / $val2); 
			break;
			case '*':
				$results = ($val1 * $val2); 
			break;
			case '%':
				$results = ($val1 % $val2); 
			break;
		}
		return $results;
	}
	
	
}

?>
