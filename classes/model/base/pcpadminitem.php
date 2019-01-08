<?php

/* 
 * class shared with admin items such as plugins and actiondefs
 */

class Model_Base_PCPAdminItem extends Model
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
}


?>
