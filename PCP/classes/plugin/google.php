<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class plugin_google implements ipcpplugin
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
	
	public function getHooks()
	{
		// This is a comma seperated list of hooks to call this plugin from
		return 'display_scene_column_left,display_scene_column_right,display_footer';
	}
	
	public function install()
	{
		// This function is called from the Plugin Admin when searching for plugins
		// If the plugin is not already installed it will call this function
	
		// If we wanted to create a table to support this plugin we could do it here:
		/*
		$q = '	CREATE TABLE `pointclickpress`.`hello_world` (
					`id` INT NOT NULL
					) ENGINE = InnoDB;';
		$q_results = DB::query(NULL,$q,TRUE)->execute();
		*/		
		
		// but we have nothing to install so just return true
		return true;
	}
		
	public function execute($hook_name='')
	{						
		/*
			You are passed the hook you are currently being called from
			You can use this to decide to perform different actions
		*/
		switch($hook_name)
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
