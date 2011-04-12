<?php 
/*
	If statement
	if(array(
	 			array($var,">",3,900)
	 			,array($var,$operator,$var2,$cell_id_to_click)
	 		)
		)
 */
define('IF','IF');
class action_if extends Model_Base_PCPActionDef
{
	
	protected $label = 'If'; 
	protected $description = 'Example: if(array(array($var,$operator,$var2,$cell_id_to_click),array($var,"<",$var2,901)))';
	
	public function performAction($args=array(),$hook_name='')
	{
		$results = parent::performAction($args);
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		foreach($expressions as $expression)
		{
			if (preg_match('/if(.+)/',trim($expression)))
			{
				$expression = substr($expression,9,-3); // get rid of 'if(array(' and ')))'
				$expression = preg_replace('/array\(/','',$expression);// get rid of inner 'array('
				$a = explode('),',$expression); //  split if multiple clause
				
				foreach($a as $if)
				{
					$i = explode(',',$if_statement);	
											
					$var1 =  $this->getValueFromArray($this->getVariableName($if_statement[0]),Storydata::getStorydata());
					$operator = $this->getOperator($if_statement[1]);
					$var2 = $this->getValueFromArray($this->getVariableName($if_statement[2]),Storydata::getStorydata());
					$cell_to_click = $if_statement[3];
						
					if($operator!=null)
					{	
						// finally evaluate						
						if($this->evaluate($this->removeQuotes($var1),$operator,$this->removeQuotes($var2)))
						{
							// if true: create a response for the event timer
							$args = array('action_value'=>"0;$cell_to_click");
							$t = new Action_eventtimer();
							$results = $t->performAction($args);
							break;
						}						
					}
				}				
			}
			$results .= $results;
		}
		return $results;
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
