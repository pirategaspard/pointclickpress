<?php 
/*
	Evaluate event & scene refresh class for PointClickPress
	Execute arbitrary PHP code.
 */

class action_EvalRefreshitems extends action_refreshitems
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = "Eval w/ Item Refresh";
		$this->description = "Execute arbitrary PHP code then refreshes items in scene. Use with caution." ;	
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
		
		$results = parent::execute($args,$story_data);
		return $results;
	}
}
?>
