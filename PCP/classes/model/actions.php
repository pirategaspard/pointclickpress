<?php defined('SYSPATH') or die('No direct script access.');

/*
		Frontend actions helper class. 
*/

class Model_Actions
{	
	// get a single action object and populate it based on the arguments
	static function getAction($args=array())
	{		
		// if we have been passed a type, get that specific type of action, otherwise save a generic action	
		if (isset($args['action_type']))
		{
			// what kind of action are we getting? 
			switch ($args['action_type'])
			{	
				case ACTION_TYPE_ITEMDEF:					
					$action = self::getItemDefAction($args);					
				break;
				case ACTION_TYPE_ITEMSTATE:					
					$action = self::getItemStateAction($args);					
				break;
				case ACTION_TYPE_GRIDITEM:					
					$action = self::getGridItemAction($args);					
				break;
				case ACTION_TYPE_GRID:					
					$action = self::getGridAction($args);					
				break;
				case ACTION_TYPE_SCENE:
					$action = self::getSceneAction($args);
				break;
				case ACTION_TYPE_LOCATION:
					$action = self::getLocationAction($args);
				break;
				case ACTION_TYPE_STORY:
					$action = self::getStoryAction($args);
				break;
				default:
					$action = new Model_Action($args);
				break;
			}
		}
		else
		{
			$action = new Model_Action($args);
		}
		return $action->load($args);
	}
	
	static function getStoryAction($args=array())
	{
		// get a single action object and populate it based on the arguments
		$action = new Model_StoryAction($args);
		return $action->load($args);
	}
	
	static function getLocationAction($args=array())
	{
		// get a single action object and populate it based on the arguments
		$action = new Model_locationAction($args);
		return $action->load($args);
	}
	
	static function getSceneAction($args=array())
	{
		// get a single action object and populate it based on the arguments
		$action = new Model_SceneAction($args);
		return $action->load($args);
	}
	
	static function getGridAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_GridAction($args);
		return $action->load($args);
	}
	
	static function getItemDefAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_ItemdefAction($args);
		return $action->load($args);
	}
	
	static function getItemStateAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_ItemstateAction($args);
		return $action->load($args);
	}
	
	static function getGridItemAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_GridItemAction($args);
		return $action->load($args);
	}
	
	static function getActions($args=array())
	{				
		if (!isset($args['action_type'])) {$args['action_type']=ACTION_TYPE_NULL;}	
		
		// what kind of action are we getting? 
		switch ($args['action_type'])
		{	
			case ACTION_TYPE_ITEMSTATE:
				$actions = self::getItemStateActions($args);
			break;
			case ACTION_TYPE_ITEMDEF:
				$actions = self::getItemDefActions($args);
			break;
			case ACTION_TYPE_GRIDITEM:
				$actions = self::getGridItemActions($args);
			break;
			case ACTION_TYPE_SCENE:
				$actions = self::getSceneActions($args);
			break;
			case ACTION_TYPE_LOCATION:
				$actions = self::getLocationActions($args);
			break;
			case ACTION_TYPE_STORY:
				$actions = self::getStoryActions($args);
			break;
			default:
				$actions = array();
			break;
		}

		return $actions;
	}
	
	static function getStoryActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.story_id
				FROM actions e
				INNER JOIN stories_actions b
					ON (b.action_id = e.id
					AND b.story_id = :story_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':story_id',$args['story_id'])
					->execute()
					->as_array();			
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getStoryAction()->init($e);
		}
		return $actions;		
	}
	
	static function getLocationActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.location_id
				FROM actions e
				INNER JOIN locations_actions b
					ON (b.action_id = e.id
					AND b.location_id = :location_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':location_id',$args['location_id'])
					->execute()
					->as_array();			
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getLocationAction()->init($e);
		}
		return $actions;		
	}
	
	static function getSceneActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.scene_id
				FROM actions e
				INNER JOIN scenes_actions b
					ON (b.action_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getSceneAction()->init($e);
		}
		return $actions;		
	}
	
	static function getGridActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.grid_action_id,
						b.scene_id
				FROM actions e
				INNER JOIN grids_actions b
					ON (b.action_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();			
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getGridAction()->init($e);
		}
		return $actions;		
	}
	
	static function getItemDefActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.itemdef_id
				FROM actions e
				INNER JOIN items_defs_actions b
					ON (e.id = b.action_id
					AND b.itemdef_id = :itemdef_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemdef_id',$args['itemdef_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getItemStateAction()->init($e);
		}
		return $actions;		
	}
	
	static function getItemStateActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.itemstate_id
				FROM actions e
				INNER JOIN items_states_actions b
					ON (e.id = b.action_id
					AND b.itemstate_id = :itemstate_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemstate_id',$args['itemstate_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getItemstateAction()->init($e);
		}
		return $actions;		
	}
	
	static function getGridItemActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.griditem_id
				FROM actions e
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
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getGriditemAction()->init($e);
		}
		return $actions;		
	}

	/* create an action */
	static function createAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		$args = array(	'action'=>$action
				,'action_value'=>$action_value
				,'type'=>$type
				,'action_label'=>$action_label
				,'story_id'=>$story_id
				);
		$action = self::getAction($args);
		return $action;
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doActions($actions)
	{
		$action_results = array();
		// get session 
		$session = Session::instance();
		//get story_data from session. This is the info actions are allowed to manipulate
		$story_data = $session->get('story_data',array());
		foreach($actions as $action)
		{
			// 'action' is the class name			
			$class_name = $action->action;
			// get the class
			$action_obj = new $class_name; 
			if ($action_obj instanceof iPCPaction)
			{
				// execute action. actions manipulate session's "story_data" info
				$action_results = array_merge($action_results,$action_obj->execute(array('action_value'=>$action->action_value),$story_data));
				//$action_results = $action_class->execute(array('action_value'=>$action->action_value),$story_data);
			}
			else
			{
				throw new Kohana_Exception($class_name . ' is not of type iPCPaction.');
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
	static function doAction($action)
	{	
		$actions[] = $action;
		return self::doActions($actions);							
	}
	
	// creates an action and then does it, useful when programming custom actions with eval()
	static function makeAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		$action = self::createAction($action,$action_value,$type,$action_label,$story_id);
		$action_results = self::doAction($action);
		return $action_results;
	}
	
	static function getJSActionDefs()
	{	
		return Cache::instance()->get('js_action_defs',actionsAdmin::cacheJSActionDefs());
	}


	/* Library functions for use in action objects */

	static function Tokenize($value,$char = ';')
	{
		// explode on semi-colon if there is more than one statement here 
		// then filter out any null or empty strings
		return array_values(array_filter(explode($char,$value))); 
	}

	// Regex used for parsing expressions in the action classes
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
