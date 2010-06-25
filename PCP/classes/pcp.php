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
		$scene_value = '';
		$container = Containers::getContainer(array('id'=>$container_id,'include_scenes'=>TRUE));
		if (count($container->values) > 0)		
		{		
			$session = Session::instance();
			$globals = $session->get('globals',array());
			$values = array_intersect_key($globals,array_flip($container->values)); // get global values that have the same key as the container value(s)
			/*
			print_r($globals);
			print_r($container->values);
			print_r($values);
			*/
			
			/* 
				If there is a scene in the current scene container with
				a global value of '1', then show that scene.
				This is how to switch between versions of a scene
				in a scene container
			*/	
			foreach($values as $key=>$value)
			{							
				if ($value == '1') // if the flag is equal to 1 
				{
					$scene_value = $key; // scene value can only be one
					break; 
				}
			}
		}
		
		return Scenes::getSceneByContainerId($container_id,$scene_value); 
	}
	
	/* 
	  	a cell in a scene has been clicked, 
	  	get the action attached to the cell (if there is one) 
	 */
	static function getAction($scene_id,$cell_id)
	{
		$results['success'] = 0;
		
		$q = '	SELECT sa.*
				FROM scene_action_cells sac
				INNER JOIN scene_actions sa
				ON (sa.id = sac.action_id
				AND sa.scene_id = :scene_id)
				WHERE sac.id = :cell_id';
		$events = DB::query(Database::SELECT,$q,TRUE)
								->param(':scene_id',$scene_id)
								->param(':cell_id',$cell_id)
								->execute()
								->as_array();
		
		if (count($events) > 0)
		{
			$results['success'] = 1;
			$results['events'] = $events;
		}
		return $results;
	}
	
	/*
		When a user clicks on a cell this function determines 
		if there is an action assigned to the cell
    */
	static function getCellAction()
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
			$results = PCP::getAction($scene->id,$cell_id);
			
			if ($results['success'] == 1 )
			{
				$event_occured = PCP::determineEvents($results['events']);
			}			
		}
		return $event_occured;	
	}

	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static private function determineEvents($events)
	{
		$event_occured = 0;
		
		foreach($events as $event)
		{
			$session = Session::instance();
			$class_name = 'event_'.$event['event'];
			$action_class = new $class_name;
			$event_occured = $action_class->execute(array('event_value'=>$event['event_value']),&$session);
		}
		return $event_occured;		
	}
	
	/* 
	  This function takes an array of values and adds them to the 
	  story globals array held in session
	 */
	static function updateGlobalVars($values=array())
	{
		// reset global story variables in session 
		$session = Session::instance();
		$globals = $session->get('globals',array());
		$session->set('globals',array_merge($globals,$values));		
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
		if (!isset($args['include_actions'])) { $args['include_actions'] = FALSE; }
		
		return $args;
	}
	
	static function getScreens()
	{	
		return Screens::getScreens();
	}
}
?>
