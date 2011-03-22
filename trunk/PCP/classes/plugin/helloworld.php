<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class plugin_helloworld implements Interface_iPCPPlugin
{
	public function getClass()
	{
		// This is the class name of this plugin
		return get_class($this);
	}
		
	public function getLabel()
	{
		// This is the label for this plugin
		return 'helloworld';
	}
		
	public function getDescription()
	{
		// This is the description of this plugin
		return 'This is the helloworld demonstration plugin';
	}
	
	public function getEvents()
	{
		// This is a comma seperated list of events to call this plugin from
		return 'post_start_story,display_pre_scene,display_post_scene';
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
		
	public function execute($event_name='')
	{						
		/*
			You are passed the event you are currently being called from
			You can use this to decide to perform different actions
		*/
		switch($event_name)
		{
			case 'display_pre_scene':
			{
				echo('This is the Hello World Demo Plugin!');
				break;
			}
			case 'display_post_scene':
			{
				// Don't forget that you can include other files from here!
				include('helloworld/index.htm');
				break;
			}			
		}
		
		/* 
			You can also access session from here!
			You could add something awesome, or do some damage
		*/
		$session = Session::instance();
		
		// uncomment the code block below for secret cheat to go immediately to last scene in the first story!
		/*
		if ($event_name == 'post_start_story')
		{
			// get story data out of session
			$story_data = $session->get('story_data',array());
			// update the current location id to #28 (last scene)			
			$story_data['location_id'] = 28;
			//save story data back into session
			$story_data = $session->set('story_data',$story_data);
		}
		*/
					
	}
}
