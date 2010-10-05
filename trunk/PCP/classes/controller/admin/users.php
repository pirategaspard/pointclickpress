<?php defined('SYSPATH') or die('No direct script access.');

class Controller_admin_users extends Controller_Template_Admin
{

	function action_index()
	{
		//$this->action_list();
	}	
	
	function action_list()
	{
		$data['users'] = PCPAdmin::getUsers();
		$this->template->content = View::factory('/admin/user/list',$data)->render();
		$this->template->top_menu = View::factory('/admin/user/top_menu',$data)->render();
	}
	
	function action_edit()
	{
		$data['user'] = PCPAdmin::getUser();
		$data['user_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'save')));
		$data['user_form'] = View::factory('/admin/user/form',$data)->render();
		$this->template->content = View::factory('/admin/user/template',$data)->render();
		$this->template->top_menu = View::factory('/admin/user/top_menu',$data)->render();
	}
	
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');
		if(count($_POST) > 0)
		{
			if ((isset($_POST['id']))&&($_POST['id'] > 0))
			{
				$result = PCPAdmin::getUser()->init($_POST)->save();	
			}
			else
			{
				$result = UsersAdmin::create($_POST);
			}
			unset($_POST);
		}
		else
		{
			$result = new pcpresult(0,'unable to save user');
		}
		if ($result->success)
		{
			$result->message = "User Saved";
		}
		$session->set('result',$result);
		//redirect to edit the story just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'edit')).'?user_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');
		$result = PCPAdmin::getUser()->init(array('id'=>$_REQUEST['user_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "User Deleted";
		}
		elseif($result->success == 0)
		{
			$result->message = "Unable to Delete User";
		}
		$session->set('result',$result);
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'list')));
	}

	
	function action_login()
	{
		$data['login_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'users','action'=>'dologin')));
		$data['user_form'] = View::factory('/admin/user/form_login',$data)->render();
		$this->template->header = '';
		$this->template->content = View::factory('/admin/user/template',$data)->render();
	}
	
	function action_dologin()
	{
		if (!Usersadmin::isloggedin())
		{
			if($_POST)
			{
				$result = Usersadmin::authenticate($_POST['username'], $_POST['password']);
				if(($result->success)&&(($result->data['id'])>0))
				{
					Usersadmin::login($result->data['id']);
					Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')));
				}
				else
				{
					Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'Login')));	
				}
			}
			else
			{
				Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'Login')));	
			}
		}
		else        
		{
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'Login')));	
		}
	}
	
	function action_logout()
	{
		$this->action_dologout();
	}
	
	function action_dologout()
	{
		Usersadmin::logout();
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'Login')));
	}
}
?>
