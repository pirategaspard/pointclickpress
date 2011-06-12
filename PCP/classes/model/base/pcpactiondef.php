<?php
/*
	Base Class for PointClickPress actions
 */

define('NOP', 'NOP'); // No Operation action response
class Model_Base_PCPActionDef extends Model_Base_PCPAdminItem implements Interface_iPCPActionDef
{
	// default is all action types allowed
	protected $allowed_action_types = Array(ACTION_TYPE_NULL,ACTION_TYPE_STORY,ACTION_TYPE_LOCATION,ACTION_TYPE_SCENE,ACTION_TYPE_GRID,ACTION_TYPE_ITEMDEF,ACTION_TYPE_ITEMSTATE,ACTION_TYPE_GRIDITEM);
	// comma seperated list of event names
	protected $events = Array(); 
	
	public function getAllowedActionTypes()
	{
		return $this->allowed_action_types;
	}
	
	public function getEvents()
	{
		return $this->events;
	}
	
	public function performAction($args=array(),$hook_name='')
	{
		// return message response
		$response = new pcpresponse(NOP,array()); 
		return $response->asArray();
	}
	
	// call action as event listener 
	public function execute($hook_name='')
	{
		$this->performAction(array(),$hook_name);
	}
	
	/* Library functions for use in action objects */

	static function tokenize($value,$char = ';')
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
		if (self::isVariable($var)||self::isNumeric($var))
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
		if (self::isVariable($var)||self::isNumeric($var)||self::isString($var))
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
		return trim(preg_replace('[\$| ]','',$var));
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
		$key = self::removeQuotes(trim($key));
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
		if (preg_match('/strcmp|===|<=|>=|<>|!=|==|<|>|\+|-|\/|\*|%/',$expression, $ops))
		{
			$operators = $ops;
		}
		return $operators;
	}
	
	static function getOperator($expression)
	{
		$expression = self::removeQuotes(trim($expression));
		$operator = null;
		$operators = self::getOperators($expression);
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
