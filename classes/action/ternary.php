<?php 
/*
	Simple Ternary 'if' action class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class action_ternary extends Model_Base_PCPActionDef
{	
	protected $label = "Ternary 'If' statement";
	protected $description = "Assign a variable using a ternary 'If' statement \$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;" ;		
	
	private $story_data = array();
	
	public function performAction($args=array(),$hook_name='')
	{		
		$results = array();
		$parsed = array(); // array of results
		$this->story_data = StoryData::getStorydata();				
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		foreach($expressions as $expression)
		{						
			// only evaluate if they are assigning a value;
			$temp = preg_split('/=/',$expression,2);
			if (count($temp) >= 2) 
			{	
				$name = trim($temp[0]);
				$value = trim($temp[1]);							
				
				// make sure the left side has a valid variable name;
				if ($this->isVariable($name))
				{																											
					$name = $this->getVariableName($name);	//remove any whitespace and strip $ from variable name so we can put it in session['story_data'][$var]																	
					//$parsed = array_merge($parsed,$this->assign($name,$value));
					$this->assign($name,$value);
				}				
			}			
		}
		// pass to the parent action to refresh the scene
		$results = parent::performAction($args);
		return $results;
	}
	
	// 
	public function assign($name,$value)
	{
		$parsed = array(); // array of results	
		// seperate if statement left & right 
		$if_statement = $this->tokenize($value,'?');		
		if (count($if_statement) == 2) 
		{					
			// get true false values 
			$values = $this->tokenize($if_statement[1],':');
			if (count($values) == 2) 
			{ 
				// get rid of the parenthesis around the if statement
				$if_statement[0] = preg_replace('/[\(\)]/','',$if_statement[0]);
				$operator = $this->getOperator($if_statement[0]);								
				if($operator!=null)
				{								
					$eval_values = $this->tokenize($if_statement[0],$operator);					
					if (count($eval_values) == 2) 
					{											
						$eval_values[0] = $this->getValueFromArray($this->getVariableName($eval_values[0]),Storydata::getStorydata());
						$eval_values[1] = $this->getValueFromArray($this->getVariableName($eval_values[1]),Storydata::getStorydata());
						$values[0] = $this->getValueFromArray($this->getVariableName($values[0]),Storydata::getStorydata());
						$values[1] = $this->getValueFromArray($this->getVariableName($values[1]),Storydata::getStorydata());		
																								
						if($this->evaluate($this->removeQuotes($eval_values[0]),$operator,$this->removeQuotes($eval_values[1])))
						{									
							Storydata::set($name,$values[0]);
						}
						else
						{
							Storydata::set($name,$values[1]);
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
			default:
				return false;
		}
	}
}
?>
