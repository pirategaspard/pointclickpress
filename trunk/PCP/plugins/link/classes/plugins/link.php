<?php 
/*
	Basic link plugin for PointClickPress
 */

class plugins_link extends Model_Base_PCPPlugin
{	
	protected $label = 'link'; // This is the label for this plugin
	protected $description = 'link to another location'; // This is the description of this plugin
	protected $events = array(ADMIN_JS,DISPLAY_POST_GRID_SELECT); // This is an array of events to call this plugin from
	
	public function execute($event_name='')
	{
		switch($event_name)
		{
			case ADMIN_JS:
			{		
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'link','admin.js'));
				break;
			}
			case DISPLAY_POST_GRID_SELECT:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'link','gridselect'));
				break;
			}
		}		
	}
}
?>
