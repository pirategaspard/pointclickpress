<?php
/*
	Base Class for PointClickPress Events
 */
class pcpevent extends model implements iPCPevent
{
	protected $class_name = '';
	protected $label = '';
	protected $description = '';

	public function __construct()
	{
		$this->class_name = get_class($this);	
	}
	
	public function getClass()
	{
		return $this->class_name;
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