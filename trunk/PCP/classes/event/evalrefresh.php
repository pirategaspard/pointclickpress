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
	$result = eval($args['event_value']);	
		if ((isset($result))&&(is_array($result))&&($result[0] instanceof pcpresponse))
		{
			$response = $result;
		}
		// our copy of $story_data may be out of date because 
		// $story_data may have been updated in the eval. 
		// so we need to refresh our copy here
		$session = Session::instance();
		$story_data = $session->get('story_data',array());
		
		// you can return your own response above otherwise default is NOP
		if(!isset($response))
		{
			parent::execute($args,$story_data);
		}
		else
		{
			return $response;
		}
	}
}
?>
