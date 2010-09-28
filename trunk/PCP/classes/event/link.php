<?php 
/*
	Basic scene location link class for PointClickPress
 */

class event_link extends event_refresh
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'link';
		$this->description = 'Create a link to another scene location';	
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		/* 
			update the location_id variable in session with 
			the new location_id from the event_value field
		*/
		$results = NOP;
		if (Events::isNumeric($args['event_value']))
		{
			// simple assignment, just update the location id 
			$story_data['location_id'] = $args['event_value'];
			// pass to the parent event to refresh the scene
			$results = parent::execute($args,$story_data);	
		}
		return $results;
	}
}
?>
