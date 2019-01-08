<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_install extends Controller_Template_Install
{
	
	function action_index()
	{		
		//list is the default action so we redirect to the install action
		$this->action_install();
	}
	
	function action_list()
	{		
		//list is the default action so we redirect to the install action
		$this->action_install();
	}
	
	function action_install()
	{		
		$this->template->content = View::factory('/admin/install/install')->render();
	}
	
}

?>
