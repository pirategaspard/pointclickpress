<?php defined('SYSPATH') or die('No direct script access.');

class PCP
{
	/* Get the Story Info to use on the story details pages and for rendering scenes */
	static function getStory($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['story_id'])) { $args['id'] = $_REQUEST['story_id']; }
		$args = PCP::getArgs($args);
		return Stories::getStoryInfo($args); // get a story object and all its Containers
	}
	
	/* get all stories available for the story list page */
	static function getStories($args=array())
	{	
		return Stories::getStories($args);		
	}
	
	/* get all the information we need to render a scene */
	static function getScene($container_id)
	{			
		$container = Containers::getContainer(array('id'=>$container_id));	
		$session = Session::instance();
		$story_data = $session->get('story_data',array());
		
		/*
			Switch for different scenes within container
			 
			if a there is a key set in the session story_data array then use that value
			othewise use empty string
		*/			
		if (isset($story_data[$container->slug]))
		{
			$scene_value = $story_data[$container->slug];
		}
		else
		{
			$scene_value = '';
		}
		return Scenes::getSceneByContainerId($container_id,$scene_value); 
	}
	
	/* 
	  	a cell in a scene has been clicked, 
	  	get the action attached to the cell (if there is one) 
	 */
	static function getCellEvent($scene_id,$cell_id)
	{
		$results['success'] = 0;
	
		$q = '	SELECT 	e.id,
						e.event,
						e.event_label,
						e.event_value
				FROM cells c
				INNER JOIN grids_events g
					ON g.grid_event_id = c.grid_event_id
				INNER JOIN events e
					ON e.id = g.event_id
				WHERE 	c.id = :cell_id
					AND c.scene_id = :scene_id
				ORDER BY e.id DESC';
		$events_temp = DB::query(Database::SELECT,$q,TRUE)
								->param(':scene_id',$scene_id)
								->param(':cell_id',$cell_id)
								->execute()
								->as_array();
		
		if (count($events_temp) > 0)
		{
			foreach($events_temp as $event_temp)
			{
				$events[] = Events::getGridEvent()->init($event_temp); 			
			}
			$results['success'] = 1;
			$results['events'] = $events;
		}
		return $results;
	}
	
	/*
		When a user clicks on a cell this function determines 
		if there is an action assigned to the cell
    */
	static function getGridEvent()
    {
		$event_occured = 0;
		
		// get session
		$session = Session::instance();					
		// get story
		$story = $session->get('story',NULL);		
		// get the scene_id
		$scene = $session->get('scene',NULL);
		
		if (($story != NULL) && ($scene != NULL) && (isset($_REQUEST['n'])))
		{				
			$cell_id = $_REQUEST['n'];
			$results = PCP::getCellEvent($scene->id,$cell_id);
			
			if ($results['success'] == 1 )
			{
				$event_occured = PCP::doEvents($results['events']);
			}			
		}
		return $event_occured;	
	}

	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doEvents($events)
	{
		$event_occured = Events::doEvents($events);
		return $event_occured;		
	}
	
	static function getCurrentContainerID()
	{
		$session = Session::instance();
		$story_data = $session->get('story_data',array());
		if (isset($story_data['container_id']))
		{
			$container_id = $story_data['container_id'];
		}
		else
		{
			$container_id = 0 ;
		}		
		return $container_id;
	}
	
	static function getContainer($container_id = 0)
	{
		$args = PCP::getArgs();
		$args['id'] = $container_id;
		return Containers::getContainer($args);
	}
	
	static private function getArgs($args=array())
	{
		if (!isset($args['story_id']) && isset($_REQUEST['story_id'])) { $args['story_id'] =  $_REQUEST['story_id']; }
		if (!isset($args['container_id']) && isset($_REQUEST['container_id'])) { $args['container_id'] = $_REQUEST['container_id']; }
		if (!isset($args['scene_id']) && isset($_REQUEST['scene_id'])) { $args['scene_id'] =  $_REQUEST['scene_id']; }
		if (!isset($args['cell_id']) && isset($_REQUEST['cell_id'])) { $args['cell_id'] =  $_REQUEST['cell_id']; }
		if (!isset($args['action_id']) && isset($_REQUEST['action_id'])) { $args['action_id'] =  $_REQUEST['action_id']; }
		
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = FALSE; }
		if (!isset($args['include_containers'])) { $args['include_containers'] = FALSE; }
		if (!isset($args['include_events'])) { $args['include_events'] = TRUE; } // always get actions 
		
		return $args;
	}
/*	
	static function getScreens()
	{	
		return Screens::getScreens();
	}
*/
}
?>
