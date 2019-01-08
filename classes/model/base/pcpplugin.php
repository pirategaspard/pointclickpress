<?php
/*
	Base Class for PointClickPress Plugins
 */
class Model_Base_PCPPlugin extends Model_Base_PCPAdminItem implements Interface_iPCPPlugin
{
	protected $events = Array(); // array of event names that this plugin should listen for
	protected $system = 0; // boolean to indicate if plugin is system-wide or story specfic
	
	public function getEvents()
	{
		return $this->events;
	}
	
	public function getSystemStatus()
	{
		return $this->system;
	}
	
	public function install()
	{
		return true; 
	}
	
	public function uninstall()
	{
		return true; 
	}
	
	public function execute($event_name='')
	{
		// do nothing
	}
}

?>
