<?php 
/*
	Evaluate action & scene refresh class for PointClickPress
	Execute arbitrary PHP code.
 */

class action_evalrefreshitems extends action_refreshitems
{	
	protected $label = "Eval w/ Item Refresh";
	protected $description = "Execute arbitrary PHP code then refreshes items in scene. Use with caution." ;	
	
	public function performAction($args=array(),$hook_name='')
	{							
		$results = parent::performAction($args);	
		$refresh = new action_refreshitems;
		$results = $refresh->performAction($args);
		return $results;
	}
}
?>
