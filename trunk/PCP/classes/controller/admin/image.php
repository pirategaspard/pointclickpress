<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_image extends Controller_Template_Admin
{
	
	function action_index()
	{
		//$this->action_list();
	}
	
	function action_edit()
	{		
		$data['image'] = PCPAdmin::getImage();
		$data['image_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'save')));		
		//$data['image_info'] =  View::factory('/admin/image/info',$data)->render();			
		$data['image_form'] =  View::factory('/admin/image/form',$data)->render();		
				
		$this->template->content = View::factory('/admin/image/template',$data)->render();
	}
	
	function action_list()
	{		
		
		$data['images'] = PCPAdmin::getImages();	
		$this->template->content = View::factory('/admin/image/list',$data)->render();
	}
	
	function action_save()
	{
		$results = array();
		if(count($_POST) > 0)
		{
			$results = PCPAdmin::getimage()->init($_POST)->save();
			unset($_POST);
		}
		else
		{
			$results = 'error';
		}
		//redirect to add a new story
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')).'?&image_id='.$results['id']);
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getimage()->init(array('id'=>$_REQUEST['image_id']))->delete();
		//Go back to the parent
		//Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id='.$_REQUEST['story_id']);
	}
}

?>
