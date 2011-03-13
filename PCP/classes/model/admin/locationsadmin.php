<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Locations helper file.
 * Contains functions for getting location and locations and managing locations in the PCP admin
 * */

class Model_Admin_LocationsAdmin extends Model_PCP_Locations
{
	static function getData()
	{
		$session = Session::instance();	
		$data = array();
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
			$data['id'] = $data['location_id'] = $_REQUEST['location_id'];	
		}
		else if ($session->get('location_id'))
		{
			$data['id'] =  $data['location_id'] = $session->get('location_id');
		}
		else
		{
			$data['id'] =  $data['location_id'] =  0;
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
