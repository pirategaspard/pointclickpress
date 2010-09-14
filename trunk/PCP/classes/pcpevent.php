<?php
/*
	Base Class for PointClickPress Events
 */
class pcpevent extends model implements iPCPevent
{
	protected $event = '';
	protected $label = '';
	protected $description = '';

	public function __construct()
	{
		$this->event = get_class($this);	
	}
	
	public function getEvent()
	{
		return $this->event;
	}
	
	public function getLabel()
	{
		return $this->label;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		;// Extend this
	}
	
	public function __get($prop)
	{			
		return $this->$prop;
	}
}

?>
