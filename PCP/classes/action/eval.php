<?php 
/*
	Evaluate event class for PointClickPress
	Execute arbitrary PHP code. 
 */

class action_Eval extends Model_Base_PCPAction
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
		$result = eval($args['action_value']);	
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
			$response = new pcpresponse(NOP,array()); 
			return $response->asArray();
		}
		return $response;
	}
}
?>
