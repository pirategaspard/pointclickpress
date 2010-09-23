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
		$data['add_image_link'] =  View::factory('/admin/image/add',$data)->render();
		
		$this->template->header = '' ;
		$this->template->top_menu = View::factory('/admin/image/top_menu',$data)->render();						
		$this->template->content = View::factory('/admin/image/template',$data)->render();
	}
	
	function action_list()
	{	
		$session = Session::instance();	
		if ($session->get('scene_id'))	
		{
			$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		}
		else
		{						
			$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		}
		$data['images'] = PCPAdmin::getImages(array('story_id'=>$session->get('story_id')));
		if ($session->get('scene_id'))
		{
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'assign')));
		}	
		$data['add_image_link'] =  View::factory('/admin/image/add',$data)->render();
		
		$this->template->header = '' ;
		$this->template->top_menu = View::factory('/admin/image/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/image/list',$data)->render();
	}
	
	function action_save()
	{		
		$session = Session::instance();
		$results = Images::upload();
		$session->set('results',$results);
		if ($results['success'])
		{			
			if ($session->get('scene_id'))
			{
				$session->set('image_id',$results['image_id']);
				action_assign();
			}	
			else
			{
				Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')));
			}
		}
		else
		{
			//var_dump($results); die();
			//error;
			$params = $this->getURLParams();
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')));		
		}
	}
	
	function action_assign()
	{		
		$session = Session::instance();				
		if ($session->get('scene_id') && $session->get('image_id'))
		{
			$scene = PCPAdmin::getScene();
			$results = $scene->init(array('image_id'=>$session->get('image_id')))->save();
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		}
		else
		{
			//Go back to the parent
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'list')));
		}
	}
	
	function action_delete()
	{		
		$results = Images::getimage()->init(array('id'=>$_REQUEST['id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'edit')));
	}
}

?>
