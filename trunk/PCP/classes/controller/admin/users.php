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
		//if (Usersadmin::instance()->logged_in())
		//	{
			$data['users'] = PCPAdmin::getUsers();
			$this->template->content = View::factory('/admin/user/list',$data)->render();
			$this->template->top_menu = View::factory('/admin/user/top_menu',$data)->render();
		//}
	}
	
	function action_edit()
	{
		//if (Usersadmin::instance()->logged_in())
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
			if ((isset($_POST['id']))&&($_POST['id'] > 0))
			{
				$results = PCPAdmin::getUser()->init($_POST)->save();	
			}
			else
			{
				$results = UsersAdmin::create($_POST);
			}
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
		if (Usersadmin::instance()->logged_in())
		{
			
			$results = PCPAdmin::getUser()->init(array('id'=>$_REQUEST['user_id']))->delete();
			//Go back to the parent
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')));
		}
	}
	
	/*
	
	function action_login()
	{
		if (!Usersadmin::instance()->logged_in())
		{
			if($_POST)
			{
				$result = Usersadmin::instance()->login($_POST['username'], $_POST['password'], false);
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
