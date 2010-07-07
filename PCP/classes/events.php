<?php defined('SYSPATH') or die('No direct script access.');

class Events
{	
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
			$class_name = $event->event;
			// get the class
			$event_class = new $class_name; 
			//execute event. Events can directly manipulate session's "story_data" info
			$event_occured = $event_class->execute(array('event_value'=>$event->event_value),$story_data);
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
		if (preg_match('/[<=|>=|<>|!=|==|<|>|+|-|\/|*|%]/',$expression, $ops))
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
}

?>
