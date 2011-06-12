<?php 
/*
	Basic link plugin for PointClickPress
 */

class plugins_points extends Model_Base_PCPPlugin
{	
	protected $label = 'Points'; // This is the label for this plugin
	protected $description = 'Allows for Users to accumulate points'; // This is the description of this plugin
	protected $events = array('ACTION_REFRESH_EVENT',POST_SCENE_BOTTOM_MENU,POST_START_STORY); // This is an array of events to call this plugin from
	
	public function execute($event_name='')
	{
		switch($event_name)
		{
			case 'ACTION_REFRESH_EVENT':
			{		
				//include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'link','admin.js'));
				echo '<p id="points">'.Storydata::get('_plugin_points',0).'</p>';
				break;
			}
			case POST_SCENE_BOTTOM_MENU:
			{
				echo '<p id="points">'.Storydata::get('_plugin_points',0).'</p>';
				break;
			}
			case POST_START_STORY:
			{
				// at the start of the story set the points to zero
				Storydata::set('_plugin_points',0); 
				break;
			}
		}		
	}
}
?>
