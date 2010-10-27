<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_image extends Controller_Template_Admin
{
	
	function action_index()
	{}
	
	function action_edit()
	{		
		$session = Session::instance();	
		$data['image'] = PCPAdmin::getImage();
		$data['story_id'] = $session->get('story_id');
		$data['scene_id'] = $session->get('scene_id');
		$data['itemstate_id'] = $session->get('itemstate_id');
		if ($session->get('itemstate_id'))
		{
			$data['type_id'] = 2; 
		}
		else
		{
			$data['type_id'] = 1; 	
		}
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
		$data['story_id'] = $session->get('story_id');
		$data['scene_id'] = $session->get('scene_id');
		$data['itemstate_id'] = $session->get('itemstate_id');
		$data['item_id'] = $session->get('item_id');
		if ($session->get('scene_id'))	
		{			
			$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		}
		else
		{					
			$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		}		
		if ($session->get('itemstate_id'))
		{
			$data['type_id'] = 2; 
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'assignImage')));
		}
		elseif ($session->get('scene_id'))
		{
			$data['type_id'] = 1;
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignImage')));
		}	
		elseif ($session->get('story_id'))
		{
			$data['type_id'] = 1;
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'assignImage')));
		}
		$data['add_image_link'] =  View::factory('/admin/image/add',$data)->render();
		$data['images'] = PCPAdmin::getImages(array('story_id'=>$session->get('story_id'),'type_id'=>$data['type_id']));
		$this->template->header = '' ;
		$this->template->footer = '' ;
		$this->template->top_menu = View::factory('/admin/image/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/image/list',$data)->render();
	}
	
	function action_save()
	{		
		$session = Session::instance();
		$args = array();
		if (strlen($session->get('itemstate_id')) > 0)
		{
			$args['type_id'] = 2;
		}
		else
		{
			$args['type_id'] = 1;
		}
		$result = ImagesAdmin::upload($args);
		$session->set('result',$result);
		if ($result->success)
		{			
			if ($session->get('scene_id'))
			{
				$session->set('image_id',$result->data['image_id']);
			}	
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'list')));	
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');	
		$result = ImagesAdmin::getimage()->init(array('id'=>$_REQUEST['id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Image Deleted";
		}
		else
		{
			$result->message = "Unable to Delete Image";
		}
		$session->set('result',$result);
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'list')));
	}
}

?>
