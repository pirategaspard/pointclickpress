<?php 
/*
	Basic scene location link class for PointClickPress
 */

class action_link extends action_refresh
{	
	public function __construct()
	{
		// init this action
		parent::__construct();
		$this->label = 'link';
		$this->description = 'Create a link to another scene location';	
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		/* 
			update the location_id variable in session with 
			the new location_id from the action_value field
		*/
		$results = NOP;
		if (Actions::isNumeric($args['action_value']))
		{
			// simple assignment, just update the location id 
			$story_data['location_id'] = $args['action_value'];
			// pass to the parent action to refresh the scene
			$results = parent::execute($args,$story_data);	
		}
		return $results;
	}
}
?>
