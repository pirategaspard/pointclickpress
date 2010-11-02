<?php 
/*
	Simple Ternary 'if' event class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class event_EvalRefresh extends event_refresh
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = "Eval w/ Scene Refresh";
		$this->description = "Execute arbitrary PHP code then refreshes the scene. Use with caution." ;	
	}
	
	public function execute($args=array(),&$story_data=array())
	{							
		eval($args['event_value']);
		return parent::execute($args,$story_data);
	}
}
?>
