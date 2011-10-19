<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class plugins_googlead extends Model_Base_PCPPlugin
{
	protected $label = 'Google Adsense'; // This is the label for this plugin
	protected $description = 'This is the Google Adsense plugin'; // This is the description of this plugin
	protected $events = array(DISPLAY_COLUMN_LEFT,DISPLAY_COLUMN_RIGHT,DISPLAY_FOOTER); // This is an array of events to call this plugin from
	protected $system = 1;

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
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'googlead','adsense1'));
				break;
			}
			case DISPLAY_COLUMN_RIGHT:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'googlead','adsense2'));
				break;
			}	
			case DISPLAY_FOOTER:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'googlead','adsense3'));
				break;
			}		
		}	
	}
}
