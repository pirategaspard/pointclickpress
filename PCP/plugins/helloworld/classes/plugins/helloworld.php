<?php defined('SYSPATH') or die('No direct script access.');
/*
	This is the example plugin for PointClickPress
 */

class plugins_helloworld extends Model_Base_PCPPlugin
{
	protected $label = 'helloworld'; // This is the label for this plugin
	protected $description = 'This is the helloworld demonstration plugin'; // This is the description of this plugin
	protected $events = array(POST_START_STORY,DISPLAY_PRE_SCENE,DISPLAY_POST_SCENE); // This is an array of events to call this plugin from
			
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
			case DISPLAY_PRE_SCENE:
			{
				echo('This is the Hello World Demo Plugin!');
				break;
			}
			case DISPLAY_POST_SCENE:
			{
				// Don't forget that you can include other files from here!
				include(Kohana::find_file('plugins\helloworld','index','htm'));
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
