<?php 
/*
	Evaluate action & scene refresh class for PointClickPress
	Execute arbitrary PHP code.
 */

class action_evalrefresh extends action_eval
{	
	protected $label = "Eval w/ Scene Refresh";
	protected $description = "Execute arbitrary PHP code then refreshes the scene. Use with caution." ;	
	protected $allowed_action_types = array(ACTION_TYPE_GRID,ACTION_TYPE_GRIDITEM);		
	
	public function performAction($args=array(),$hook_name='')
	{							
		$results = parent::performAction($args);	
		$refresh = new action_refresh;
		$results = $refresh->performAction($args);
		return $results;
	}
}
?>
