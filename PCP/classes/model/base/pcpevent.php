<?php
/*
	Base Class for PointClickPress Events
 */

define('NOP', 'NOP'); // No Operation event response
class Model_Base_PCPEvent extends Model implements interfaces_iPCPevent
{
	protected $class_name = '';
	protected $label = '';
	protected $description = '';
	protected $allowed_event_types = Array(EVENT_TYPE_NULL,EVENT_TYPE_STORY,EVENT_TYPE_LOCATION,EVENT_TYPE_SCENE,EVENT_TYPE_GRID,EVENT_TYPE_ITEMDEF,EVENT_TYPE_ITEMSTATE,EVENT_TYPE_GRIDITEM);

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
	
	public function getAllowedTypes()
	{
		return $this->allowed_event_types;
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		// return message response
		$response = new pcpresponse(NOP,array()); 
		return $response->asArray();
	}
}

?>
