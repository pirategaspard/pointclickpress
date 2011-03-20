<?php 
/*
	Evaluate action & scene refresh class for PointClickPress
	Execute arbitrary PHP code.
 */

class action_EvalRefresh extends action_refresh
{	
	public function __construct()
	{
		// init this action
		parent::__construct();
		$this->label = "Eval w/ Scene Refresh";
		$this->description = "Execute arbitrary PHP code then refreshes the scene. Use with caution." ;	
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
