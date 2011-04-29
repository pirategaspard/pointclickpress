<?php defined('SYSPATH') or die('No direct script access.');

class Controller_admin_storyplugin extends Controller_Template_Admin
{
	function action_liststoryplugins()
	{
		$this->simple_output();
		$data = Model_Admin_Storypluginsadmin::getData();
		$data['plugins'] = Model_Admin_storypluginsadmin::getStoryPlugins($data);
		$this->template->content = View::factory('/admin/storyplugin/list',$data)->render();	
	}
	
	function action_ChangeStatus()
	{
		$data = Model_Admin_Storypluginsadmin::getData();			
		$sp = Model_Admin_storypluginsadmin::getStoryPlugin($data);
		//toggle status
		if ($sp->status == 0)
		{
			$data['status'] = 1;
		}
		else
		{
			$data['status'] = 0;
		}
		//var_dump($data); die();	
		$sp->init($data)->save();
		//var_dump($sp); die();
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id='.$data['story_id']);
	}
}