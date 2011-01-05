<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Scenes helper file.
 * Contains functions for getting location and Scenes and managing Scenes in the PCP admin
 * */

class SceneAdmin
{

	static function getScenes($args=array())
	{
		return Model_Scenes::getScenes($args);
	}

	static function getData()
	{
		$session = Session::instance();	
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['location_id']))
		{
			$data['location_id'] = $_REQUEST['location_id'];	
		}
		else if ($session->get('location_id'))
		{
			$data['location_id'] = $session->get('location_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];				
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');
		}
		return $data;
	}

}
?>
