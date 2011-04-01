<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class plugin_column extends Model_Base_PCPPlugin
{
	protected $label = 'columns'; // This is the label for this plugin
	protected $description = 'This is the columns plugin'; // This is the description of this plugin
	protected $events = array(DISPLAY_COLUMN_LEFT,DISPLAY_COLUMN_RIGHT); // This is an array of events to call this plugin from
		
	public function execute($event_name='')
	{						
		/*
			You are passed the event you are currently being called from
			You can use this to decide to perform different actions
		*/
		switch($event_name)
		{
			case DISPLAY_COLUMN_LEFT:
			{
				echo('This is the left column!');
				break;
			}
			case DISPLAY_COLUMN_RIGHT:
			{
				echo('This is the right column!');
				break;
			}			
		}	
	}
}
