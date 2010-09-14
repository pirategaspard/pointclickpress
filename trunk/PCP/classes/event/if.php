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
		$this->description = 'Assign a new value to story_data based on an if statement $var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;' ;	
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		$results = NOP;
		$parsed = array(); // array of results
		
		// explode on semi-colon if there is more than one statement here
		$name_val_pairs = explode(';',$args['event_value']); 
		foreach($name_val_pairs as $expression)
		{
			
			//echo $expression; 
			//echo '=';
			
			// only evaluate if they are assigning a value;
			$temp = preg_split('/=/',$expression,2);
			if (count($temp) >= 2) 
			{	
				//echo (' isvar: '.Events::isVariable(trim($temp[0])));
				// make sure the left side has a valid variable name;
				if (Events::isVariable(trim($temp[0])))
				{
					//remove any whitespace and strip $ from variable name so we can put it in session['story_data'][$var]
					$var = Events::getVariableName(trim($temp[0]));
					
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
							$operator = Events::getOperator($if_statement[0]);
							
							if($operator!=null)
							{
								$eval_values = explode($operator,$if_statement[0]);
								if (count($eval_values) == 2) 
								{
									$eval_values[0] = Events::replaceSessionVariables($eval_values[0]);
									$eval_values[1] = Events::replaceSessionVariables($eval_values[1]);
									$values[0] = Events::replaceSessionVariables($values[0]);
									$values[1] = Events::replaceSessionVariables($values[1]);
									
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
									$results = REFRESH_SCENE .',SHOW_MESSAGE';
									//echo (' results: '.$parsed[$var]);
								}
							}
						}
					}
					
				}
				
			}			
		}
		//update story_data
		$story_data = array_merge($story_data,$parsed);
		//die();
		return $results;
	}
}
?>
