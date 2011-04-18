<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Story helper file.
 * Contains functions for managing stories in the PCP admin
 * */

class Model_Admin_StoriesAdmin extends Model_PCP_Stories
{	
	static function getData()
	{
		$session = Session::instance('admin');	
		$data['id'] = $data['story_id'] = $session->get('story_id',0);
		Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['id'] = $data['story_id'] = $_REQUEST['story_id'];		
		}
		else if ($session->get('story_id'))
		{
			$data['id'] = $data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['image_id']))
		{
			$data['image_id'] = $_REQUEST['image_id'];	
		}
		else if ($session->get('image_id'))
		{
			$data['image_id'] = $session->get('image_id');
		}
		return $data;
	}
}
