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
	
	static function getContainer($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('container_id')) { $args['id'] =  $session->get('container_id'); }
		return Containers::getContainer($args); // get a scene container object
	}
	
	static function getContainers($args=array())
	{	
		$args = PCPAdmin::getArgs($args);
		return Containers::getContainers($args);		
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
		return EventsAdmin::getEvent($args); // get a event object and all its Containers
	}
	
	static function getEvents($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return EventsAdmin::getEvents($args); // get a story object and all its Containers
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
	
	/* get a scene by container ID and value */
	static function getSceneByContainerId($container_id,$value='')
	{
		return Scenes::getSceneByContainerId($container_id,$value='');
	}


	static private function getArgs($args=array())
	{

		$session = Session::instance();
		if (isset($_REQUEST['story_id']))
		{
			$session->set('story_id',$_REQUEST['story_id']);
		}
		if (isset($_REQUEST['container_id']))
		{
			$session->set('container_id',$_REQUEST['container_id']);
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
				
		if (!isset($args['story_id']) && $session->get('story_id')) { $args['story_id'] =  $session->get('story_id'); }
		if (!isset($args['container_id']) && $session->get('container_id')) { $args['container_id'] = $session->get('container_id'); }
		if (!isset($args['scene_id']) && $session->get('scene_id')) { $args['scene_id'] =  $session->get('scene_id'); }
		if (!isset($args['cell_id']) &&  $session->get('cell_id')) { $args['cell_id'] =   $session->get('cell_id'); }
		if (!isset($args['event_id']) &&  $session->get('event_id')) { $args['event_id'] =   $session->get('event_id'); }
		if (!isset($args['image_id']) &&  $session->get('image_id')) { $args['image_id'] =   $session->get('image_id'); }
		
		// defaults
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = TRUE; }
		if (!isset($args['include_containers'])) { $args['include_containers'] = TRUE; }
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
