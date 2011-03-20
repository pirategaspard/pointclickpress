<?php
/*
	Base Class for PointClickPress actions
 */

define('NOP', 'NOP'); // No Operation action response
class Model_Base_PCPAction extends Model implements interfaces_iPCPAction
{
	protected $class_name = '';
	protected $label = '';
	protected $description = '';
	protected $allowed_action_types = Array(ACTION_TYPE_NULL,ACTION_TYPE_STORY,ACTION_TYPE_LOCATION,ACTION_TYPE_SCENE,ACTION_TYPE_GRID,ACTION_TYPE_ITEMDEF,ACTION_TYPE_ITEMSTATE,ACTION_TYPE_GRIDITEM);

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
		return $this->allowed_action_types;
	}
	
	public function execute($args=array(),&$story_data=array())
	{
		// return message response
		$response = new pcpresponse(NOP,array()); 
		return $response->asArray();
	}
}

?>
