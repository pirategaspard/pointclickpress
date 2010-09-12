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
		if (strlen($data['image']->filename) > 0)
		{
			$data['image_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'delete')));			
		}
		else
		{
			$data['image_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'save')));
		}
		
						
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['image_form'] =  View::factory('/admin/image/form',$data)->render();		
		
		$this->template->top_menu = View::factory('/admin/event/top_menu',$data)->render();						
		$this->template->content = View::factory('/admin/image/template',$data)->render();
	}
	
	function action_list()
	{		
		if (isset($_REQUEST['scene_id']))	
		{
			$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit'))).'?scene_id='.$_REQUEST['scene_id'];
		}
		else
		{						
			$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		}
		$data['images'] = PCPAdmin::getImages();
		if (isset($_REQUEST['scene_id']))
		{
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'assign'))).'?scene_id='.$_REQUEST['scene_id'];
		}	
		
		$this->template->top_menu = View::factory('/admin/event/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/image/list',$data)->render();
	}
	
	function action_save()
	{		
		$results = Images::upload();
		if ($results['success'])
		{			
			if (isset($_REQUEST['scene_id']))
			{
				$_REQUEST['image_id'] = $results['image_id'];
				action_assign();
			}	
			else
			{
				//redirect to edit screen
				$params = $this->getURLParams();
				Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')).$params.'&image_id='.$results['image_id']);
			}
		}
		else
		{
			//error;
			// We aren't saving anything, go back to edit
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')).$params.'&image_id='.$_REQUEST['id']);		
		}
	}
	
	function action_assign()
	{				
		if ((isset($_REQUEST['scene_id']))&&isset($_REQUEST['image_id']))
		{
			$scene = PCPAdmin::getScene();
			$results = $scene->init(array('image_id'=>$_REQUEST['image_id']))->save();
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$_REQUEST['scene_id']);
		}
		else
		{
			//Go back to the parent
			$params = $this->getURLParams();
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'list')).$params);
		}
	}
	
	function action_delete()
	{	
		$params = $this->getURLParams();	
		$results = Images::getimage()->init(array('id'=>$_REQUEST['id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')).$params);
	}
	
	function getURLParams()
	{
		if (isset($_REQUEST['scene_id']))
		{
			$params = '?story_id='.$_REQUEST['scene_id'];
		}
		else
		{
			$params = '?';
		}

		if (isset($_REQUEST['scene_id']))
		{
			$params .= '&scene_id='.$_REQUEST['scene_id'];
		}
		return $params;
	}
}

?>
