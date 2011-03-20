<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class Plugin_Google implements Interfaces_iPCPPlugin
{
	public function getClass()
	{
		// This is the class name of this plugin
		return get_class($this);
	}
		
	public function getLabel()
	{
		// This is the label for this plugin
		return 'Google integration';
	}
		
	public function getDescription()
	{
		// This is the description of this plugin
		return 'This is the Google Integration plugin';
	}
	
	public function getEvents()
	{
		// This is a comma seperated list of events to call this plugin from
		return 'display_scene_column_left,display_scene_column_right,display_footer';
	}
	
	public function install()
	{
		// we have nothing to install so just return true
		return true;
	}
		
	public function execute($event_name='')
	{						
		/*
			You are passed the event you are currently being called from
			You can use this to decide to perform different actions
		*/
		switch($event_name)
		{
			case 'display_scene_column_left':
			{
				include('google/adsense1.php');
				break;
			}
			case 'display_scene_column_right':
			{
				include('google/adsense2.php');
				break;
			}	
			case 'display_footer':
			{
				include('google/analytics.php');
				break;
			}		
		}	
	}
}
