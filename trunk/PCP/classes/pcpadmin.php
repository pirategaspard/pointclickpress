<?php defined('SYSPATH') or die('No direct script access.');

class PCPAdmin
{
	static function getStory($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['story_id'])) { $args['id'] = $_REQUEST['story_id']; }
		$args = PCPAdmin::getArgs($args);
		return Stories::getStory($args); // get a story object and all its Containers
	}
	
	static function getStoryInfo($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['story_id'])) { $args['id'] = $_REQUEST['story_id']; }
		$args = PCPAdmin::getArgs($args);
		return Stories::getStoryInfo($args); // get a story object and all its Containers
	}
	
	static function getStories($args=array())
	{	
		//if (!isset($args['user_id'])) { $args['user_id'] = '' }	
		return Stories::getStories($args);		
	}
	
	static function getContainer($args=array())
	{
		if (!isset($args['id'])  && isset($_REQUEST['container_id'])) { $args['id'] = $_REQUEST['container_id']; }
		$args = PCPAdmin::getArgs($args);
		return Containers::getContainer($args); // get a story object and all its Containers
	}
	
	static function getContainers($args=array())
	{	
		$args = PCPAdmin::getArgs($args);
		return Containers::getContainers($args);		
	}
	
	static function getScene($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['scene_id'])) { $args['id'] =  $_REQUEST['scene_id']; }
		$args = PCPAdmin::getArgs($args);
		return Scenes::getScene($args); // get a scene object
	}
	
	static function getScenes($args=array())
	{		
		$args = PCPAdmin::getArgs($args);
		return Scenes::getScenes($args);
	}
	
	static function getAction($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['action_id'])) { $args['id'] =  $_REQUEST['action_id']; }
		$args = PCPAdmin::getArgs($args);
		return Actions::getAction($args); // get a story object and all its Containers
	}
	
	static function getActions($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return Actions::getActions($args); // get a story object and all its Containers
	}
	
	static private function getArgs($args=array())
	{
		if (!isset($args['story_id']) && isset($_REQUEST['story_id'])) { $args['story_id'] =  $_REQUEST['story_id']; }
		if (!isset($args['container_id']) && isset($_REQUEST['container_id'])) { $args['container_id'] = $_REQUEST['container_id']; }
		if (!isset($args['scene_id']) && isset($_REQUEST['scene_id'])) { $args['scene_id'] =  $_REQUEST['scene_id']; }
		if (!isset($args['cell_id']) && isset($_REQUEST['cell_id'])) { $args['cell_id'] =  $_REQUEST['cell_id']; }
		if (!isset($args['action_id']) && isset($_REQUEST['action_id'])) { $args['action_id'] =  $_REQUEST['action_id']; }
		
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = TRUE; }
		if (!isset($args['include_containers'])) { $args['include_containers'] = TRUE; }
		if (!isset($args['include_actions'])) { $args['include_actions'] = TRUE; }
		
		return $args;
	}
	
	static function getScreens()
	{	
		return Screens::getScreens();
	}	
}
?>
