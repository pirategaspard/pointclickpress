<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_plugin extends Controller_Template_Admin
{
	
	function action_list()
	{		
		Model_Admin_PluginsAdmin::searchForListeners(); // search for new Plugins
		Model_Admin_ActionDefsAdmin::searchForListeners(); // search for new ActionDefs
		
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
			$result = Model_Admin_PluginsAdmin::update($plugin[0]['id'],$status);
		}
		else
		{
			$result = new pcpresult(false,'Could not load plugin');
		}
		$session = Session::instance('admin');	
		$session->set('result',$result);
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
	
	function action_save()
	{		
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
	
	function action_delete()
	{			
		$plugin = Model_Admin_PluginsAdmin::getByClassName(array('plugin'=>$_REQUEST['plugin']));
		if(count($plugin) > 0)
		{					
			// delete record
			$result = Model_Admin_PluginsAdmin::deleteByID($plugin[0]['id']);
			$session = Session::instance('admin');
			$session->set('result',$result);
		}		
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
}

?>
