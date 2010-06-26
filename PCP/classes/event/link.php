<?php 
/*
	Basic scene container link class for PointClickPress
 */

class event_link extends pcpevent
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'link';
		$this->description = 'Create a link to another scene container';	
	}
	
	public function execute($args=array(),$session=null)
	{
		/* 
			update the container_id variabel in session with 
			the new container_id from the event_value field
		*/
		$session->set('container_id',$args['event_value']);
		return 1;
	}
}
?>
