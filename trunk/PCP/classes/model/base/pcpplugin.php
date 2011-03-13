<?php
/*
	Base Class for PointClickPress Plugins
 */
class Model_Base_PCPPlugin extends Model implements Interfaces_iPCPPlugin
{
	protected $class_name = ''; // this class name 
	protected $label = ''; // name of plugin
	protected $description = ''; // description of plugin
	protected $hooks = ''; // comma seperated list of hook names

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
	
	public function getHooks()
	{
		return $this->hooks;
	}
	
	public function install()
	{
		return true; 
	}
	
	public function execute($hook_name='')
	{
		// do nothing
	}
}

?>
