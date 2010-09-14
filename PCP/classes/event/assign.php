<?php 
/*
	Basic session variable assignment class for PointClickPress
 */

class event_assign extends pcpevent
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'Assign value';
		$this->description = 'Assign a new value to a session variable';	
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		$results = NOP;
		$parsed = array(); // array of results
		
		// explode on semi-colon if there is more than one statement here
		$name_val_pairs = explode(';',$args['event_value']); 
		foreach($name_val_pairs as $expression)
		{
			// only evaluate if they are assigning a value;
			$temp = preg_split('/=/',$expression,2);
			if (count($temp) == 2) 
			{
				// make sure the left side has a valid variable name;
				if (Events::isVariable(trim($temp[0])))
				{
					//remove any whitespace and strip $ from variable name so we can put it in session['story_data'][$var]
					$var = Events::getVariableName(trim($temp[0]));
					$exp = trim($temp[1]);
					
					
					if (Events::isVariableOrNumeric($exp))
					{
						/* 
							SIMPLE VALUE
							detect simple value statement in the form of 
							1; or $var;
						*/
						
						//echo (' simple assignment: ');
						$parsed[$var] = Events::replaceSessionVariables($exp);
						$results = REFRESH_SCENE;
					}
					else if (Events::isString($exp))
					{
						/* 
							SIMPLE VALUE
							detect simple value statement in the form of 
							1; or $var;
						*/
						
						//echo (' simple assignment: ');
						$parsed[$var] = preg_replace('/[\'"]/','',$exp);
						$results = REFRESH_SCENE;
					}
					else if(preg_match('/((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\s*([\+\-\*\/])\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))/',$exp))
					{
						/* 
							MATH
							detect math statement in the form of 
							$var + 1; $var - 1; 1 * 1; $var + $var; $var['blah'] + $var['blah'];
						*/
						//echo (' math: ');
						$operator = Events::getOperator($exp);
						$eval_values = explode($operator,$exp);
						if (count($eval_values) == 2) 
						{
							$eval_values[0] = Events::replaceSessionVariables($eval_values[0]);
							$eval_values[1] = Events::replaceSessionVariables($eval_values[1]);
							$parsed[$var] = Events::doBasicMath($operator,$eval_values[0],$eval_values[1]);	
							$results = REFRESH_SCENE;						
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