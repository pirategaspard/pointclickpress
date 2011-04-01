<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_plugin extends Controller_Template_Admin
{
	
	function action_list()
	{		
		$data['plugins'] = Model_Admin_PluginsAdmin::load();
		$data['add'] = '';//View::factory('/admin/story/add',$data)->render();
		$this->template->top_menu = View::factory('/admin/plugin/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/plugin/list',$data)->render();
	}
	
	function action_edit()
	{		
		$plugin = Model_Admin_PluginsAdmin::getByClassName(array('plugin'=>$_REQUEST['plugin']));
		if(count($plugin) > 0)
		{
			if ($plugin[0]['status'] == 0)
			{
				$status = 1;
			}
			else
			{
				$status = 0;
			}
			if (Model_Admin_PluginsAdmin::update($plugin[0]['id'],$status))
			{
				$result = new pcpresult();
			}
			else
			{
				$result = new pcpresult(false,'Plugin did not save');
			}
		}
		else
		{
			$result = new pcpresult(false,'Could not load plugin');
		}
		$session = Session::instance();	
		$session->set('result',$result);
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
	
	function action_save()
	{		
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
	
	function action_delete()
	{
		$plugin = Model_Admin_PluginsAdmin::getByClassName(array('plugin'=>$_REQUEST['plugin']));
		if(count($plugin) > 0)
		{
			// TODO: run un-install function in plugin
			
			// delete record
			Model_Admin_PluginsAdmin::deleteByID($plugin[0]['id']);
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
	
}

?>
