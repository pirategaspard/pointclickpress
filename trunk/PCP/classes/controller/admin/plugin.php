<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_plugin extends Controller_Template_Admin
{
	
	function action_list()
	{		
		$data['plugins'] = PCPAdmin::getPlugins();
		$data['add'] = '';//View::factory('/admin/story/add',$data)->render();
		$this->template->top_menu = View::factory('/admin/plugin/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/plugin/list',$data)->render();
	}
	
	function action_edit()
	{		
		$plugin = PCPAdmin::getPlugin(array('plugin'=>$_REQUEST['plugin']));
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
			if (pluginAdmin::updatePlugin($plugin[0]['id'],$status))
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
		/*		
		$data['form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'save'))); 		
		$this->template->top_menu = View::factory('/admin/plugin/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/plugin/form',$data)->render();
		*/
	}
	
	function action_save()
	{		
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'plugin','action'=>'list')));
	}
	
}

?>
