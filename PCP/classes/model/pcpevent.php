<?php
/*
	Base Class for PointClickPress Events
 */

define('NOP', 'NOP'); // No Operation event name
class Model_pcpevent extends Model implements iPCPevent
{
	protected $class_name = '';
	protected $label = '';
	protected $description = '';
	protected $event_type_list = '';

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
		// return message response
		$response = new pcpresponse(NOP,array()); 
		return $response->asArray();
	}
}

?>
