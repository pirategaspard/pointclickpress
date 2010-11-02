<?php 
/*
	Simple Ternary 'if' event class for PointClickPress
	 
	$var = (eval_value1 [>|<|<=|>=|==|!=] eval_value1 ) ? true_value1 : false_value 2;
 */

class event_Eval extends pcpevent
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = "Eval";
		$this->description = "Execute arbitrary PHP code. Use with caution." ;	
	}
	
	public function execute($args=array(),&$story_data=array())
	{									
		eval($args['event_value']);	
		$response = new pcpresponse(NOP,array()); 
		return $response->asArray();
	}
}
?>
