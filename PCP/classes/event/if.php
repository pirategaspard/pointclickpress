<?php 
class event_if extends event_ternary
{	
	private $story_data = array();
	
	public function __construct()
	{
		// init this event
		parent::__construct();
	}
	
	public function execute($args=array(),&$story_data=array())
	{		
		return parent::execute($args,$story_data);
	}
}
?>
