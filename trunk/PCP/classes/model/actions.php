<?php defined('SYSPATH') or die('No direct script access.');

/*
		Frontend events helper class. 
*/

class Model_Actions
{	
	// get a single Event object and populate it based on the arguments
	static function getAction($args=array())
	{		
		// if we have been passed a type, get that specific type of event, otherwise save a generic event	
		if (isset($args['action_type']))
		{
			// what kind of event are we getting? 
			switch ($args['action_type'])
			{	
				case ACTION_TYPE_ITEMDEF:					
					$event = self::getItemDefAction($args);					
				break;
				case ACTION_TYPE_ITEMSTATE:					
					$event = self::getItemStateAction($args);					
				break;
				case ACTION_TYPE_GRIDITEM:					
					$event = self::getGridItemAction($args);					
				break;
				case ACTION_TYPE_GRID:					
					$event = self::getGridAction($args);					
				break;
				case ACTION_TYPE_SCENE:
					$event = self::getSceneAction($args);
				break;
				case ACTION_TYPE_LOCATION:
					$event = self::getLocationAction($args);
				break;
				case ACTION_TYPE_STORY:
					$event = self::getStoryAction($args);
				break;
				default:
					$event = new Model_Action($args);
				break;
			}
		}
		else
		{
			$event = new Model_Action($args);
		}
		return $event->load($args);
	}
	
	static function getStoryAction($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_StoryAction($args);
		return $event->load($args);
	}
	
	static function getLocationAction($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_locationAction($args);
		return $event->load($args);
	}
	
	static function getSceneAction($args=array())
	{
		// get a single event object and populate it based on the arguments
		$event = new Model_SceneAction($args);
		return $event->load($args);
	}
	
	static function getGridAction($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_GridAction($args);
		return $event->load($args);
	}
	
	static function getItemDefAction($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_ItemdefAction($args);
		return $event->load($args);
	}
	
	static function getItemStateAction($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_ItemstateAction($args);
		return $event->load($args);
	}
	
	static function getGridItemAction($args=array())
	{		
		// get a single event object and populate it based on the arguments
		$event = new Model_GridItemAction($args);
		return $event->load($args);
	}
	
	static function getActions($args=array())
	{				
		if (!isset($args['action_type'])) {$args['action_type']=ACTION_TYPE_NULL;}	
		
		// what kind of event are we getting? 
		switch ($args['action_type'])
		{	
			case ACTION_TYPE_ITEMSTATE:
				$events = self::getItemStateActions($args);
			break;
			case ACTION_TYPE_ITEMDEF:
				$events = self::getItemDefActions($args);
			break;
			case ACTION_TYPE_GRIDITEM:
				$events = self::getGridItemActions($args);
			break;
			case ACTION_TYPE_SCENE:
				$events = self::getSceneActions($args);
			break;
			case ACTION_TYPE_LOCATION:
				$events = self::getLocationActions($args);
			break;
			case ACTION_TYPE_STORY:
				$events = self::getStoryActions($args);
			break;
			default:
				$events = array();
			break;
		}

		return $events;
	}
	
	static function getStoryActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.story_id
				FROM events e
				INNER JOIN stories_actions b
					ON (b.action_id = e.id
					AND b.story_id = :story_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':story_id',$args['story_id'])
					->execute()
					->as_array();			
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getStoryAction()->init($e);
		}
		return $events;		
	}
	
	static function getLocationActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.location_id
				FROM events e
				INNER JOIN locations_actions b
					ON (b.action_id = e.id
					AND b.location_id = :location_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':location_id',$args['location_id'])
					->execute()
					->as_array();			
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getLocationAction()->init($e);
		}
		return $events;		
	}
	
	static function getSceneActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.scene_id
				FROM events e
				INNER JOIN scenes_actions b
					ON (b.action_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getSceneAction()->init($e);
		}
		return $events;		
	}
	
	static function getGridActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.grid_action_id,
						b.scene_id
				FROM events e
				INNER JOIN grids_actions b
					ON (b.action_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();			
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getGridAction()->init($e);
		}
		return $events;		
	}
	
	static function getItemDefActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.itemdef_id
				FROM events e
				INNER JOIN items_defs_actions b
					ON (e.id = b.action_id
					AND b.itemdef_id = :itemdef_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemdef_id',$args['itemdef_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getItemStateAction()->init($e);
		}
		return $events;		
	}
	
	static function getItemStateActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.itemstate_id
				FROM events e
				INNER JOIN items_states_actions b
					ON (e.id = b.action_id
					AND b.itemstate_id = :itemstate_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemstate_id',$args['itemstate_id'])
					->execute()
					->as_array();
		$events = array();
		foreach($tempArray as $e)
		{
			$events[$e['id']] = self::getItemstateAction()->init($e);
		}
		return $events;		
	}
	
	static function getGridItemActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.event,
						e.action_label,
						e.action_value,
						b.griditem_id
				FROM events e
				INNER JOIN grids_items_actions b
					ON (e.id = b.action_id
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
			$events[$e['id']] = self::getGriditemAction()->init($e);
		}
		return $events;		
	}

	/* create an event */
	static function createAction($event='',$action_value='',$type='event',$action_label='',$story_id=0)
	{
		$args = array(	'event'=>$event
				,'action_value'=>$action_value
				,'type'=>$type
				,'action_label'=>$action_label
				,'story_id'=>$story_id
				);
		$event = self::getAction($args);
		return $event;
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doActions($events)
	{
		$action_results = array();
		// get session 
		$session = Session::instance();
		//get story_data from session. This is the info events are allowed to manipulate
		$story_data = $session->get('story_data',array());
		foreach($events as $event)
		{
			// 'event' is the class name			
			$class_name = $event->event;
			// get the class
			$action_obj = new $class_name; 
			if ($action_obj instanceof iPCPevent)
			{
				// execute event. Events manipulate session's "story_data" info
				$action_results = array_merge($action_results,$action_obj->execute(array('action_value'=>$event->action_value),$story_data));
				//$action_results = $action_class->execute(array('action_value'=>$event->action_value),$story_data);
			}
			else
			{
				throw new Kohana_Exception($class_name . ' is not of type iPCPEvent.');
			}
		}
		//update session
		$session->set('story_data',$story_data); 
		return $action_results;		
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doAction($event)
	{	
		$events[] = $event;
		return self::doActions($events);							
	}
	
	// creates an event and then does it, useful when programming custom events with eval()
	static function makeAction($event='',$action_value='',$type='event',$action_label='',$story_id=0)
	{
		$event = self::createAction($event,$action_value,$type,$action_label,$story_id);
		$action_results = self::doAction($event);
		return $action_results;
	}
	
	static function getJSActionDefs()
	{	
		return Cache::instance()->get('js_action_defs',EventsAdmin::cacheJSActionDefs());
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
		$operators = Actions::getOperators($expression);
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
