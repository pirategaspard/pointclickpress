<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Itemstates helper file.
 * Contains functions for getting Itemstate and Itemstates and managing Itemstates in the PCP admin
 * */

class Model_Admin_ItemstateAdmin extends Model_PCP_Itemstates
{
	static function getData()
	{
		$session = Session::instance('admin');	
		$data = $_POST;
		//Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];	
			$data['add_id'] = 'story_id='.$data['story_id'];		
		}
		elseif ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');	
			$data['add_id'] = 'story_id='.$session->get('story_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];	
			$data['add_id'] = 'scene_id='.$data['scene_id'];			
		}
		if (isset($_REQUEST['itemdef_id']))
		{
			$data['itemdef_id'] = $_REQUEST['itemdef_id'];	
			$data['add_id'] = 'itemdef_id='.$data['itemdef_id'];			
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$data['id'] = $data['itemstate_id'] = $_REQUEST['itemstate_id'];
		}
		if (isset($_REQUEST['image_id']))
		{
			$data['image_id'] = $_REQUEST['image_id'];
		}
		$data['item_type'] = ACTION_TYPE_ITEMSTATE;
		$data['user_id'] = $data['creator_user_id'] = Auth::instance()->get_user()->id;
		return $data;
	}

}
?>
