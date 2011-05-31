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
		$results = array();			
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here	
		foreach($expressions as $expression)
		{		
			if (preg_match('/if(.+)/',trim($expression)))
			{
				$expression = substr($expression,9,-3); // get rid of 'if(array(' and ')))'
				$expression = preg_replace('/array\(/','',$expression);// get rid of inner 'array('
				$a = explode('),',$expression); //  split if multiple clause

				foreach($a as $if_statement)
				{
					$if_statement = preg_replace('/\)/','',$if_statement);
					$i = explode(',',$if_statement);
						
					if (count($i) == 4)
					{						
						$var1 =  $this->getValueFromArray($this->getVariableName(trim($i[0])),Storydata::getStorydata());
						$operator = $this->removeQuotes(trim($i[1])); //$this->getOperator($i[1]);
						$var2 = $this->getValueFromArray($this->getVariableName(trim($i[2])),Storydata::getStorydata());
						$cell_to_click = trim($i[3]);
																																			
						if($operator!=null)
						{	
							// finally evaluate						
							if($this->evaluate($var1,$operator,$var2))
							{
								// if true: create a response for the event timer
								$args = array('action_value'=>"0,$cell_to_click");
								$t = new Action_eventtimer();
								$results2 = $t->performAction($args);
								$results = array_merge($results,$results2);								
								break;
							}						
						}
					}
				}							
			}			
		}		
		if (count($results) == 0 )
		{
			$results = parent::performAction($args);
		}
		return $results;
	}
	
	public function evaluate($var1,$operator,$var2)
	{					
		switch (trim($operator))
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
			break;
		}
	}
}
