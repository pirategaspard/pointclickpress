<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class plugins_google extends Model_Base_PCPPlugin
{
	protected $label = 'Google integration'; // This is the label for this plugin
	protected $description = 'This is the Google Integration plugin'; // This is the description of this plugin
	protected $events = array(DISPLAY_COLUMN_LEFT,DISPLAY_COLUMN_RIGHT,DISPLAY_FOOTER); // This is an array of events to call this plugin from

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
				include(Kohana::find_file('plugins\google','adsense1'));
				break;
			}
			case DISPLAY_COLUMN_RIGHT:
			{
				include(Kohana::find_file('plugins\google','adsense2'));
				break;
			}	
			case DISPLAY_FOOTER:
			{
				include(Kohana::find_file('plugins\google','analytics'));
				break;
			}		
		}	
	}
}
