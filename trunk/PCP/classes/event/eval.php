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
		// if you return an array it will consider it the parsed results
		elseif((isset($result))&&(is_array($result)))
		{
			$story_data = array_merge($story_data,$result);
		}

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
