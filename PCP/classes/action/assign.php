<?php 
/*
	Basic session variable assignment class for PointClickPress.	 
	Examples:	
	$door_open = 1;
	$visits = $visits + 1;
	$mylocation = 'NORTH'; //Remember that location slugs are session variables that can be assigned a scene value!
 */
define('ASSIGN','ASSIGN');
class action_assign extends Model_Base_PCPActionDef
{	
	
	protected $label = 'Assign value'; 
	protected $description = 'Assign a new value to a session variable. Example: $door_open = 1;';
	protected $events = array(ASSIGN);
	
	private $story_data = array();
	
	public function performAction($args=array(),&$story_data=array(),$hook_name='')
	{
		$results = array();
		$parsed = array(); // array of results	
		$this->story_data = $story_data;						
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		foreach($expressions as $expression)
		{
			// only evaluate if they are assigning a value;
			$temp = preg_split('/=/',$expression,2);			
			if (count($temp) == 2) 
			{
				$name = trim($temp[0]);
				$value = trim($temp[1]);	
				// make sure the left side has a valid variable name;
				if ($this->isVariable($name))
				{					
					$name = $this->getVariableName($name);	//remove any whitespace and strip $ from variable name so we can put it in session['story_data'][$var]		
					$parsed = array_merge($parsed,$this->assign($name,$value));
				}				
			}
		}
		if (count($parsed) > 0)
		{
			//update story_data
			$story_data = array_merge($story_data,$parsed);		
			// pass to the parent action to refresh the scene
			$results = parent::performAction($args,$story_data);
		}		
		//var_dump($story_data); die();
		return $results;
	}
	
	public function assign($name,$value)
	{
		$parsed = array(); // array of results								
		if ($this->isVariableOrNumeric($value))
		{
			/* 
				SIMPLE VALUE
				detect simple value statement in the form of 
				1; or $var;
			*/
			//echo (' simple assignment: ');					
			//echo($this->getValueFromArray($this->getVariableName($value),$this->story_data));
			$parsed[$name] = $this->getValueFromArray($this->getVariableName($value),$this->story_data);
		}
		else if ($this->isString($value))
		{
			/* 
				SIMPLE VALUE
				detect simple value statement in the form of 
				1; or $var;
			*/
			//echo (' simple assignment: '.preg_replace('/[\'"]/','',$value));
			$parsed[$name] = $this->removeQuotes($value);	
		}
		else if(preg_match('/((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\s*([\+\-\*\/])\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))/',$value))
		{
			/* 
				MATH
				detect math statement in the form of 
				$name + 1; $name - 1; 1 * 1; $name + $name; $name['blah'] + $name['blah'];
			*/
			//echo (' math: ');
			$operator = $this->getOperator($value);
			$math_values = $this->tokenize($value,$operator);
			if (count($eval_values) == 2) 
			{
				$math_values[0] = $this->getValueFromArray($this->getVariableName($math_values[0]),$this->story_data);
				$math_values[1] = $this->getValueFromArray($this->getVariableName($math_values[1]),$this->story_data);
				$parsed[$name] = $this->doBasicMath($math_values[0],$operator,$math_values[1]);														
			}
		}	
		return $parsed;
	}
}
?>
