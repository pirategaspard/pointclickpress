<?php 
/*
	Basic scene location link class for PointClickPress
 */

class action_link extends action_refresh
{	
	protected $label = 'Link';
	protected $description = 'Create a link to another scene location';
	
	public function performAction($args=array(),$hook_name='')
	{					
		/* 
			update the location_id variable in session with 
			the new location_id from the action_value field
		*/
		$results = NOP;
		if ($this->isNumeric($args['action_value']))
		{
			// simple assignment, just update the location id 
			Storydata::set('location_id',$args['action_value']);
			// pass to the parent action to refresh the scene
			$results = parent::performAction($args);	
		}
		return $results;
	}
}
?>
