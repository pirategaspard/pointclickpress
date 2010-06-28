<?php
/*
	Base Class for PointClickPress Events
 */
class pcpevent extends model 
{
	protected $event = '';
	protected $label = '';
	protected $description = '';

	public function __construct()
	{
		$this->event = get_class($this);	
	}
	
	public function getLabel()
	{
		return $this->label;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function execute($args=array(),$session=null)
	{
		// this function is meant to be extended 
	}
	
	public function __get($prop)
	{			
		return $this->$prop;
	}
}

?>
