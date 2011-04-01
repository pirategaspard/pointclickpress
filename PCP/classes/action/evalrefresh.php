<?php 
/*
	Evaluate action & scene refresh class for PointClickPress
	Execute arbitrary PHP code.
 */

class action_EvalRefresh extends action_eval
{	
	protected $label = "Eval w/ Scene Refresh";
	protected $description = "Execute arbitrary PHP code then refreshes the scene. Use with caution." ;		
	
	public function performAction($args=array(),&$story_data=array(),$hook_name='')
	{							
		$results = parent::performAction($args,$story_data);	
		$refresh = new action_refresh;
		$results = $refresh->performAction($args,$story_data);
		return $results;
	}
}
?>
