<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Scenes helper file.
 * Contains functions for getting location and Scenes and managing Scenes in the PCP admin
 * */

class Model_Admin_ScenesAdmin extends Model_PCP_Scenes
{
	static function getData()
	{
		$session = Session::instance();	
		$data = array();
		$data['story_id'] = $session->get('story_id',0);
		$data['location_id'] = $session->get('location_id',0);
		//Model_Admin_PCPAdmin::clearArgs();
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
		if (isset($_REQUEST['image_id']))
		{
			$data['image_id'] = $_REQUEST['image_id'];	
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['id'] = $data['scene_id'] = $_REQUEST['scene_id'];			
		}
		else if ($session->get('scene_id'))
		{
			$data['id'] = $data['scene_id'] = $session->get('scene_id');
		}
		else
		{
		//	$data['id'] = $data['scene_id'] =  0;
		}
		return $data;
	}
}
?>
