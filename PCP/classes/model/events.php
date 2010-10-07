<?php defined('SYSPATH') or die('No direct script access.');

class Model_Events
{	
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
		return Model_Events::doEvents($events);	
	}
	
	static function getJSEventTypes()
	{	
		//return EventsAdmin::loadJSEventTypes();
		try
		{
			$file = APPPATH.'/cache/cached_js_events.php';	
			return unserialize(file_get_contents($file));
		}
		catch(Exception $e)
		{
			return array();
		} 
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
