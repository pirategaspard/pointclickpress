<?php 
/*
	Basic scene container link class for PointClickPress
 */

class event_link extends pcpevent implements ipcpevent
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'link';
		$this->description = 'Create a link to another scene container';	
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		/* 
			update the container_id variable in session with 
			the new container_id from the event_value field
		*/
		$results = NOP;
		if (Events::isNumeric($args['event_value']))
		{
			// simple assignment
			$story_data['container_id'] = $args['event_value'];
			$results = REFRESH_SCENE;
		}
		return $results;
	}
}
?>
