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
		$data['plugin'] = PCPAdmin::getPlugin(array('plugin'=>$_REQUEST['plugin']));		
		$data['form_action'] = ''; 
		$this->template->top_menu = View::factory('/admin/plugin/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/plugin/form',$data)->render();
	}
	
}

?>
