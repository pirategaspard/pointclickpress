<?php 
/*
	Simple Ternary 'if' action class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class action_ternaryrefresh extends action_ternary
{	
	protected $label = "Ternary 'if' and scene refresh";
	protected $description = "Assign a variable using a ternary 'If' statement then refresh the scene \$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;" ;
	
	public function performAction($args=array(),$hook_name='')
	{		
		$results = parent::performAction($args);	
		$refresh = new action_refresh;
		$results = $refresh->performAction($args);
		return $results;
	}
}
?>
