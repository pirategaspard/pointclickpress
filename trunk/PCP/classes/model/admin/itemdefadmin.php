<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_ItemDefAdmin extends Model_PCP_Items
{									 
	static function getData()
	{
		$session = Session::instance();	
		$data = array();
		//Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];	
			$data['add_id'] = 'story_id='.$data['story_id'];		
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
			$data['add_id'] = 'story_id='.$data['story_id'];
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];	
			$data['add_id'] = 'scene_id='.$data['scene_id'];			
		}
		if (isset($_REQUEST['itemdef_id']))
		{
			$data['id'] = $data['itemdef_id'] = $_REQUEST['itemdef_id'];			
		}
		$data['item_type'] = ITEM_TYPE_DEF;
		return $data;
	}
	
}
