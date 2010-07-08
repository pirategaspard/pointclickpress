<?php defined('SYSPATH') or die('No direct script access.');

class Controller_admin_users extends Controller_Template_Admin
{
/*
	function action_index()
	{
		//$this->action_list();
	}
	
	function action_list()
	{
		if (Simple_Auth::instance()->logged_in())
		{
			
		}
	}
	
	function action_edit()
	{
		if (Simple_Auth::instance()->logged_in())
		{
			
		}
	}
	*/
	
	function action_dan()
	{
		$user_data = new Model_Auth_Users();
		
		$user_data->username = 'someuser';
		$user_data->password = '12345';
		$user_data->email = 'abcd@localhost';
		
		//var_dump(MODPATH);
		
		$results = simpleauth::instance()->create_user($user_data);
		var_dump($results);
	}
	
	/*
	function action_login()
	{
		if (!Simple_Auth::instance()->logged_in())
		{
			if($_POST)
			{
				$result = Simple_Auth::instance()->login($_POST['username'], $_POST['password'], false);
				if($result)
				{
					url::redirect('/about');
				}
				else
				{
					$this->template->content = 'Password or username invalid';
				}
			}
			else
			{
				$this->template->content =  new View('content_punchthru/login_form');
			}
		}
		else        
		{
			$this->template->content = 'you are already logged in';
		}
	}*/
}
?>
