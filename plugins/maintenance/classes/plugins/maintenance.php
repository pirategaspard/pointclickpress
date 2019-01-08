<?php defined('SYSPATH') or die('No direct script access.');

class plugins_maintenance extends Model_Base_PCPPlugin
{

	protected $label = 'Maintenance Page'; // This is the label for this plugin
	protected $description = 'When activated this plugin will display a maintenance page.'; // This is the description of this plugin
	protected $events = array(PCP_REQUEST_START); // This is an array of events to call this plugin from
	protected $system = 1;

	public function execute($event_name='')
	{	
		include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'maintenance'.DIRECTORY_SEPARATOR.'views','maintenancepage'));
		die();
	}
}