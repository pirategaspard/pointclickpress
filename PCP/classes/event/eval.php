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
		$result = eval($args['event_value']);	
		if ((isset($result))&&(is_array($result))&&($result[0] instanceof pcpresponse))
		{
			$response = $result;
		}
		// story_data may have been updated in the eval. 
		// so our copy may be out of date. we need to refresh our copy here
		$session = Session::instance();
		$story_data = $session->get('story_data',array());
		
		// you can return your own response above otherwise default is NOP
		if(!isset($response))
		{
			$response = new pcpresponse(NOP,array()); 
			return $response->asArray();
		}
		return $response;
	}
}
?>
