<?php defined('SYSPATH') or die('No direct script access.');

class PCPAdmin
{
	static function getStory($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('story_id')) { $args['id'] =  $session->get('story_id'); }
		return Stories::getStory($args); // get a story object 
	}
	
	static function getStoryInfo($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('story_id')) { $args['id'] =  $session->get('story_id'); }
		return Stories::getStoryInfo($args); // get a story info object 
	}
	
	static function getStories($args=array())
	{	
		//if (!isset($args['user_id'])) { $args['user_id'] = '' }	
		return Stories::getStories($args);		
	}
	
	static function getlocation($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('location_id')) { $args['id'] =  $session->get('location_id'); }
		return locations::getlocation($args); // get a scene location object
	}
	
	static function getlocations($args=array())
	{	
		$args = PCPAdmin::getArgs($args);
		return locations::getlocations($args);		
	}
	
	static function getScene($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('scene_id')) { $args['id'] =  $session->get('scene_id'); }
		return Scenes::getScene($args); // get a scene object
	}
	
	static function getScenes($args=array())
	{		
		$args = PCPAdmin::getArgs($args);
		return Scenes::getScenes($args);
	}

	static function getEvent($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('event_id')) { $args['id'] =  $session->get('event_id'); }				
		return EventsAdmin::getEvent($args); // get a event object and all its locations
	}
	
	static function getEvents($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return EventsAdmin::getEvents($args); // get a story object and all its locations
	}
	
	static function getUser($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('user_id')) { $args['id'] =  $session->get('user_id'); }
		return UsersAdmin::getUser($args); // get a user object 
	}
	
	static function getUsers($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return UsersAdmin::getUsers($args); 
	}
	
	static function getImage($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('image_id')) { $args['id'] =  $session->get('image_id'); }
		return Images::getImage($args);  
	}
	
	static function getImages($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return Images::getImages($args); 
	}
	
	/* get a scene by location ID and value */
	static function getSceneBylocationId($location_id,$value='')
	{
		return Scenes::getSceneBylocationId($location_id,$value);
	}


	static public function getArgs($args=array())
	{

		$session = Session::instance();		
		if (isset($_REQUEST['story_id']))
		{
			$session->set('story_id',$_REQUEST['story_id']);
			$session->delete('location_id');
			$session->delete('scene_id');
		}
		if (isset($_REQUEST['location_id']))
		{
			$session->set('location_id',$_REQUEST['location_id']);
		}
		if (isset($_REQUEST['scene_id']))
		{
			$session->set('scene_id',$_REQUEST['scene_id']);
		}
		if (isset($_REQUEST['cell_id']))
		{
			$session->set('cell_id',$_REQUEST['cell_id']);
		}
		if (isset($_REQUEST['event_id']))
		{
			$session->set('event_id',$_REQUEST['event_id']);
		}
		if (isset($_REQUEST['image_id']))
		{
			$session->set('image_id',$_REQUEST['image_id']);
		}
		if (isset($_REQUEST['id']))
		{
			$session->set('id',$_REQUEST['id']);
		}
		if (isset($_REQUEST['user_id']))
		{
			$session->set('user_id',$_REQUEST['user_id']);
		}
				
		if (!isset($args['story_id']) && $session->get('story_id')) { $args['story_id'] =  $session->get('story_id'); }
		if (!isset($args['location_id']) && $session->get('location_id')) { $args['location_id'] = $session->get('location_id'); }
		if (!isset($args['scene_id']) && $session->get('scene_id')) { $args['scene_id'] =  $session->get('scene_id'); }
		if (!isset($args['cell_id']) &&  $session->get('cell_id')) { $args['cell_id'] =   $session->get('cell_id'); }
		if (!isset($args['event_id']) &&  $session->get('event_id')) { $args['event_id'] =   $session->get('event_id'); }
		if (!isset($args['image_id']) &&  $session->get('image_id')) { $args['image_id'] =   $session->get('image_id'); }
		if (!isset($args['user_id']) &&  $session->get('user_id')) { $args['user_id'] =   $session->get('user_id'); }
		
		// defaults
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = TRUE; }
		if (!isset($args['include_locations'])) { $args['include_locations'] = TRUE; }
		if (!isset($args['include_events'])) { $args['include_events'] = TRUE; }
		
		return $args;
	}
	
	static function loadEventTypes()
	{
		EventsAdmin::cacheJSEventTypes(); // cache JS event files
		return EventsAdmin::loadEventTypes(); // get php event classes 
	}
	
	/*
	static function loadJSEventTypes()
	{	
		return EventsAdmin::loadJSEventTypes();
	}
	*/	
}
?>