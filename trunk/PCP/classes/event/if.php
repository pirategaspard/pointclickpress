<?php 
/*
	Simple Ternary 'if' event class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class event_if extends event_refresh
{	
	private $story_data = array();
	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'If';
		$this->description = 'Assign a new value to story_data based on an if statement $var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;' ;	
	}
	
	public function execute($args=array(),&$story_data=array())
	{		
		$results = array();
		$parsed = array(); // array of results
		$this->story_data = $story_data;				
		$expressions = Events::Tokenize($args['event_value']); // explode on semi-colon if there is more than one statement here
		foreach($expressions as $expression)
		{						
			// only evaluate if they are assigning a value;
			$temp = preg_split('/=/',$expression,2);
			if (count($temp) >= 2) 
			{	
				$name = trim($temp[0]);
				$value = trim($temp[1]);							
				
				// make sure the left side has a valid variable name;
				if (Events::isVariable($name))
				{																											
					$name = Events::getVariableName($name);	//remove any whitespace and strip $ from variable name so we can put it in session['story_data'][$var]																	
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
		return $results;
	}
	
	// 
	public function assign($name,$value)
	{
		$parsed = array(); // array of results	
		// seperate if statement left & right 
		$if_statement = Events::Tokenize($value,'?');		
		if (count($if_statement) == 2) 
		{					
			// get true false values 
			$values = Events::Tokenize($if_statement[1],':');
			if (count($values) == 2) 
			{ 
				// get rid of the parenthesis around the if statement
				$if_statement[0] = preg_replace('/[\(\)]/','',$if_statement[0]);
				$operator = Events::getOperator($if_statement[0]);								
				if($operator!=null)
				{								
					$eval_values = Events::Tokenize($if_statement[0],$operator);					
					if (count($eval_values) == 2) 
					{											
						$eval_values[0] = Events::getValueFromArray(Events::getVariableName($eval_values[0]),$this->story_data);
						$eval_values[1] = Events::getValueFromArray(Events::getVariableName($eval_values[1]),$this->story_data);
						$values[0] = Events::getValueFromArray(Events::getVariableName($values[0]),$this->story_data);
						$values[1] = Events::getValueFromArray(Events::getVariableName($values[1]),$this->story_data);		
						
						if($this->evaluate($eval_values[0],$operator,$eval_values[1]))
						{
							$parsed[$name] = $values[0];									
						}
						else
						{
							$parsed[$name] = $values[1];
						}										
					}
				}
			}
		}
		return $parsed;					
	}
			
	public function evaluate($var1,$operator,$var2)
	{			
		switch ($operator)
		{			
			case 'strcmp':
				return (strcmp($var1,$var2)); 
			break;
			case '===':
				return ($var1 === $var2); 
			break;
			case '<=':
				return ($var1 <= $var2); 
			break;
			case '>=':
				return ($var1 >= $var2); 
			break;
			case '<>':
				return ($var1 <> $var2); 
			break;
			case '!=':
				return ($var1 != $var2);  
			break;
			case '==':
				return ($var1 == $var2); 
			break;
			case '<':
				return ($var1 < $var2); 
			break;
			case '>':
				return ($var1 > $var2);  
			break;
		}
	}
}
?>
