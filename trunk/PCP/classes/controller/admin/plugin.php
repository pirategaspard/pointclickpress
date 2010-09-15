<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_plugin extends Controller_Template_Admin
{
	
	function action_list()
	{		
		var_dump(Plugins::getPlugins()); die();
	}
	
}

?>
