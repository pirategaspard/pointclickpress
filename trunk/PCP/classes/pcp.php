<?php defined('SYSPATH') or die('No direct script access.');

class PCP
{
	/* Get the Story Info to use on the story details pages and for rendering scenes */
	static function getStory($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['story_id'])) { $args['id'] = $_REQUEST['story_id']; }
		$args = PCP::getArgs($args);
		return Model_Stories::getStoryInfo($args); // get a story object and all its locations
	}
	
	/* get all stories available for the story list page */
	static function getStories($args=array())
	{	
		$args['status'] = 'p'; // only get published stories 
		return Model_Stories::getStories($args);		
	}
	
	/* get all the information we need to render a scene */
	static function getScene($args=array())
	{	
		$args['scene_value'] = DEFAULT_SCENE_VALUE;		
		if (isset($args['location_id']))
		{
			$location = Model_locations::getlocation(array('id'=>$args['location_id']));	
			$session = Session::instance();
			$story_data = $session->get('story_data',array());
			
			/*
				Switch for different scenes within location			 
				If a there is a key set in the session story_data array then use that value
				othewise use empty string
			*/			
			if (isset($story_data[$location->slug]))
			{
				$args['scene_value'] = $story_data[$location->slug];
			}
			else
			{
				$args['scene_value'] = DEFAULT_SCENE_VALUE;
			}
		}
		return Model_Scenes::getSceneBylocationId($args); 
	}
	
	/* get all the information we need to render a scene */
	static function getItemState($args=array())
	{	
		$args['itemstate_value'] = DEFAULT_ITEMSTATE_VALUE;			
		if (isset($args['slug']))
		{	
			$session = Session::instance();
			$story_data = $session->get('story_data',array());
			
			/*
				Switch for different scenes within location			 
				If a there is a key set in the session story_data array then use that value
				othewise use empty string
			*/			
			if (isset($story_data[$args['slug']]))
			{
				$args['itemstate_value'] = $story_data[$args['slug']];
			}
			else
			{
				$args['itemstate_value'] = DEFAULT_ITEMSTATE_VALUE;
			}
		}
		return Model_items::getitemstateByItemId($args); 
	}
	
	/* 
	  	a cell in a scene has been clicked, 
	  	get the action attached to the cell(s) (if any) 
	 */
	static function getCellEvent($scene_id,$cell_id)
	{
		$results = new pcpresult();
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
				$events[] = EventsAdmin::getGridEvent()->init($event_temp); 			
			}
			$results->success = 1;
			$results->data = array('events'=>$events);
		}
		return $results;
	}
	
	/*
		When a user clicks on a cell this function determines 
		if there is an action assigned to the cell
    */
	static function getGridEvent()
    {
		$event_results = array();		
		// get session
		$session = Session::instance();					
		// get story
		$story = $session->get('story',NULL);		
		// get the scene_id
		$scene = $session->get('scene',NULL);
		//if story and scene are not null and we have a cell id(n)
		if (($story != NULL) && ($scene != NULL) && (isset($_REQUEST['n'])))
		{				
			$cell_id = $_REQUEST['n'];
			$results = PCP::getCellEvent($scene->id,$cell_id);
			
			if ($results->success == 1 )
			{
				$event_results = PCP::doEvents($results->data['events']);
			}			
		}
		return $event_results;	
	}

	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doEvents($events)
	{
		$event_results = Model_Events::doEvents($events);
		return $event_results;		
	}
	
	static function getCurrentlocationID()
	{
		$session = Session::instance();
		$story_data = $session->get('story_data',array());
		if (isset($story_data['location_id']))
		{
			$location_id = $story_data['location_id'];
		}
		else
		{
			$location_id = 0 ;
		}		
		return $location_id;
	}
	
	static function getlocation($location_id = 0)
	{
		$args = PCP::getArgs();
		$args['id'] = $location_id;
		return Model_locations::getlocation($args);
	}
	
	static private function getArgs($args=array())
	{
		if (!isset($args['story_id']) && isset($_REQUEST['story_id'])) { $args['story_id'] =  $_REQUEST['story_id']; }
		if (!isset($args['location_id']) && isset($_REQUEST['location_id'])) { $args['location_id'] = $_REQUEST['location_id']; }
		if (!isset($args['scene_id']) && isset($_REQUEST['scene_id'])) { $args['scene_id'] =  $_REQUEST['scene_id']; }
		if (!isset($args['cell_id']) && isset($_REQUEST['cell_id'])) { $args['cell_id'] =  $_REQUEST['cell_id']; }
		if (!isset($args['event_id']) && isset($_REQUEST['event_id'])) { $args['event_id'] =  $_REQUEST['event_id']; }
		
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = FALSE; }
		if (!isset($args['include_locations'])) { $args['include_locations'] = FALSE; }
		if (!isset($args['include_events'])) { $args['include_events'] = TRUE; }
		if (!isset($args['include_items'])) { $args['include_items'] = TRUE; } 
		
		return $args;
	}
	
	static function getJSEventTypes()
	{	
		return Model_Events::getJSEventTypes();
	}
	
	static function getScreens()
	{
		return Model_Screens::getScreens();
	}

}
?>
