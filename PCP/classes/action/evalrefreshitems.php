<?php 
/*
	Evaluate action & scene refresh class for PointClickPress
	Execute arbitrary PHP code.
 */

class action_EvalRefreshitems extends action_refreshitems
{	
	protected $label = "Eval w/ Item Refresh";
	protected $description = "Execute arbitrary PHP code then refreshes items in scene. Use with caution." ;	
	
	public function performAction($args=array(),&$story_data=array(),$hook_name='')
	{							
		$results = parent::performAction($args,$story_data);	
		$refresh = new action_refreshitems;
		$results = $refresh->performAction($args,$story_data);
		return $results;
	}
}
?>
