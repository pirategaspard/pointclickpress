<?php defined('SYSPATH') or die('No direct script access.');

class Controller_admin_users extends Controller_Template_Admin
{
/*
	function action_index()
	{
		//$this->action_list();
	}	
	
	*/
	
	function action_list()
	{
		//if (simpleauth::instance()->logged_in())
		//	{
			$data['users'] = PCPAdmin::getUsers();
			$this->template->content = View::factory('/admin/user/list',$data)->render();
			$this->template->top_menu = View::factory('/admin/user/top_menu',$data)->render();
		//}
	}
	
	function action_edit()
	{
		//if (simpleauth::instance()->logged_in())
		//	{
			$data['user'] = PCPAdmin::getUser();
			$data['user_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'save')));
			$data['user_form'] = View::factory('/admin/user/form',$data)->render();
			$this->template->content = View::factory('/admin/user/template',$data)->render();
			$this->template->top_menu = View::factory('/admin/user/top_menu',$data)->render();
		//}
	}
	
	function action_save()
	{
		$results = array();
		if(count($_POST) > 0)
		{
			$results = PCPAdmin::getUser()->init($_POST)->save();
			unset($_POST);
		}
		else
		{
			$results = 'error';
		}
		//redirect to edit the story just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'edit')).'?user_id='.$results['id']);
	}
	
	function action_delete()
	{	
		if (simpleauth::instance()->logged_in())
		{
			
			$results = PCPAdmin::getUser()->init(array('id'=>$_REQUEST['user_id']))->delete();
			//Go back to the parent
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')));
		}
	}
	
	/*
	function action_dan()
	{
		$user_data = new Model_Auth_Users();		
		$user_data->username = 'admin';
		$user_data->password = 'admin';
		$user_data->email = 'abcd@localhost';
		$results = simpleauth::instance()->create_user($user_data);
		var_dump($results);
	}
	
	
	function action_login()
	{
		if (!simpleauth::instance()->logged_in())
		{
			if($_POST)
			{
				$result = simpleauth::instance()->login($_POST['username'], $_POST['password'], false);
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
