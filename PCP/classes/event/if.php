<?php 
/*
	Basic if event class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class event_if extends pcpevent
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'If';
		$this->description = 'Assign a new value to a session variable based on an if statement $var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;' ;	
	}
	
	public function execute($args=array(),$session=null)
	{
		$parsed = array(); // array of results
		
		// explode on semi-colon if there is more than one statement here
		$name_val_pairs = explode(';',$args['event_value']); 
		foreach($name_val_pairs as $expression)
		{
			/*
			echo $expression; 
			echo '=';
			*/
			// only evaluate if they are assigning a value;
			$temp = explode('=',$expression);
			if (count($temp) == 2) 
			{				
				// make sure the left side has a valid variable name;
				if ($this->isVariable(trim($temp[0])))
				{
					//remove any whitepsace and strip $ from variable name so we can put it in session['story_data'][$var]
					$var = $this->getVariableName(trim($temp[0]));
					//echo '?'; 
					// seperate if statement left & right 
					$if_statement = explode('?',$temp[1]);
					if (count($if_statement) == 2) 
					{
						//echo ':'; 
						// get true false values 
						$values = explode(':',$if_statement[1]);
						if (count($values) == 2) 
						{
							//echo '()'; 
							// get rid of the parenthesis around the if statement
							$if_statement[0] = preg_replace('/[\(\)]/','',$if_statement[0]);
							if (preg_match('/[<=|>=|<>|!=|==|<|>]/',$if_statement[0], $if_eval))
							{
								$operator = $if_eval[0];
							}
							
							if(isset($operator)&&(strlen($operator)>0))
							{
								$eval_values = explode($operator,$if_statement[0]);
								if (count($eval_values) == 2) 
								{
									$eval_values[0] = $this->replaceSessionVariables($eval_values[0]);
									$eval_values[1] = $this->replaceSessionVariables($eval_values[1]);
									$values[0] = $this->replaceSessionVariables($values[0]);
									$values[1] = $this->replaceSessionVariables($values[1]);
									
									switch ($operator)
									{
										case '<=':
											$parsed[$var] = ($eval_values[0] <= $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
										case '>=':
											$parsed[$var] = ($eval_values[0] >= $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
										case '<>':
											$parsed[$var] = ($eval_values[0] <> $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
										case '!=':
											$parsed[$var] = ($eval_values[0] != $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
										case '==':
											$parsed[$var] = ($eval_values[0] == $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
										case '<':
											$parsed[$var] = ($eval_values[0] < $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
										case '>':
											$parsed[$var] = ($eval_values[0] > $eval_values[1] ) ? $values[0] : $values[1]; 
										break;
									}
								}
							}
						}
					}
					
				}
				
			}			
		}
		$story_data = $session->get('story_data',array());
		$session->set('story_data',array_merge($story_data,$parsed));	
		return 1;
	}
}
?>
