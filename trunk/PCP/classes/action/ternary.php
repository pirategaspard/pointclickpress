<?php 
/*
	Simple Ternary 'if' event class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class action_Ternary extends Model_Base_PCPAction
{	
	private $story_data = array();
	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = "Ternary 'If' statement";
		$this->description = "Assign a variable using a ternary 'If' statement \$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;" ;	
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
			if (count($temp) >= 2) 
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
		return $results;
	}
	
	// 
	public function assign($name,$value)
	{
		$parsed = array(); // array of results	
		// seperate if statement left & right 
		$if_statement = Actions::Tokenize($value,'?');		
		if (count($if_statement) == 2) 
		{					
			// get true false values 
			$values = Actions::Tokenize($if_statement[1],':');
			if (count($values) == 2) 
			{ 
				// get rid of the parenthesis around the if statement
				$if_statement[0] = preg_replace('/[\(\)]/','',$if_statement[0]);
				$operator = Actions::getOperator($if_statement[0]);								
				if($operator!=null)
				{								
					$eval_values = Actions::Tokenize($if_statement[0],$operator);					
					if (count($eval_values) == 2) 
					{											
						$eval_values[0] = Actions::getValueFromArray(Actions::getVariableName($eval_values[0]),$this->story_data);
						$eval_values[1] = Actions::getValueFromArray(Actions::getVariableName($eval_values[1]),$this->story_data);
						$values[0] = Actions::getValueFromArray(Actions::getVariableName($values[0]),$this->story_data);
						$values[1] = Actions::getValueFromArray(Actions::getVariableName($values[1]),$this->story_data);		
						
						if($this->evaluate(Actions::removeQuotes($eval_values[0]),$operator,Actions::removeQuotes($eval_values[1])))
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
			case 'strcmp': // kinda cheating on this one ;)
				if (strcmp($var1,$var2) == 0)
				{
					return true;
				}
				else
				{				
					return false;
				} 
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