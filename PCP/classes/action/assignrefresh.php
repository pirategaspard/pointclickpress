<?php 
/*
	Basic session variable assignment class for PointClickPress.	 
	Examples:	
	$door_open = 1;
	$visits = $visits + 1;
	$mylocation = 'NORTH'; //Remember that location slugs are session variables that can be assigned a scene value!
 */

class action_assignrefresh extends action_refresh
{	
	private $story_data = array();
	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'Assign value and scene refresh';
		$this->description = 'Assign a new value to a session variable then refresh the scene. Example: $door_open = 1;';	
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		$results = array();
		$parsed = array(); // array of results	
		$this->story_data = $story_data;						
		$expressions = Actions::Tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		foreach($expressions as $expression)
		{
			// only evaluate if they are assigning a value;
			$temp = preg_split('/=/',$expression,2);			
			if (count($temp) == 2) 
			{
				$name = trim($temp[0]);
				$value = trim($temp[1]);	
				// make sure the left side has a valid variable name;
				if (Actions::isVariable($name))
				{					
					$name = Actions::getVariableName($name);	//remove any whitespace and strip $ from variable name so we can put it in session['story_data'][$var]		
					$parsed = array_merge($parsed,$this->assign($name,$value));
				}				
			}
		}
		if (count($parsed) > 0)
		{
			//update story_data
			$story_data = array_merge($story_data,$parsed);		
			// pass to the parent event to refresh the scene
			$results = parent::execute($args,$story_data);
		}	
		//var_dump($parsed); die();	
		return $results;
	}
	
	public function assign($name,$value)
	{
		$parsed = array(); // array of results								
		if (Actions::isVariableOrNumeric($value))
		{
			/* 
				SIMPLE VALUE
				detect simple value statement in the form of 
				1; or $var;
			*/
			//echo (' simple assignment: ');					
			echo(Actions::getValueFromArray(Actions::getVariableName($value),$this->story_data));
			$parsed[$name] = Actions::getValueFromArray(Actions::getVariableName($value),$this->story_data);
		}
		else if (Actions::isString($value))
		{
			/* 
				SIMPLE VALUE
				detect simple value statement in the form of 
				1; or $var;
			*/
			//echo (' simple assignment: '.preg_replace('/[\'"]/','',$value));
			$parsed[$name] = Actions::removeQuotes($value);	
		}
		else if(preg_match('/((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\s*([\+\-\*\/])\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))/',$value))
		{
			/* 
				MATH
				detect math statement in the form of 
				$name + 1; $name - 1; 1 * 1; $name + $name; $name['blah'] + $name['blah'];
			*/
			//echo (' math: ');
			$operator = Actions::getOperator($value);
			$math_values = Actions::Tokenize($value,$operator);
			if (count($eval_values) == 2) 
			{
				$math_values[0] = Actions::getValueFromArray(Actions::getVariableName($math_values[0]),$this->story_data);
				$math_values[1] = Actions::getValueFromArray(Actions::getVariableName($math_values[1]),$this->story_data);
				$parsed[$name] = Actions::doBasicMath($math_values[0],$operator,$math_values[1]);														
			}
		}		
		return $parsed;
	}
}
?>
