<?php 
class event_if extends event_ternaryrefresh
{	
	private $story_data = array();
	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = "old if event";
	}
	
	public function execute($args=array(),&$story_data=array())
	{		
		return parent::execute($args,$story_data);
	}
}
?>