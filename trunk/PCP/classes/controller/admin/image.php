<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_image extends Controller_Template_Admin
{
	
	function action_index()
	{}
	
	function action_edit()
	{		
		$session = Session::instance('admin');
		$data = Model_Admin_ImagesAdmin::getData();	
		$data['image'] = Model_Admin_ImagesAdmin::getImage(array('id'=>$data['id']))->init($data);
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

		$this->template->header = $this->template->top_menu; // move the top menu into the header to save space 
		$this->template->footer = '' ;
		$this->template->top_menu = '' ;					
		$this->template->content = View::factory('/admin/image/template',$data)->render();
	}
	
	function action_list()
	{	
		$session = Session::instance('admin');	
		$data = Model_Admin_ImagesAdmin::getData();	
		if (isset($data['scene_id']))
		{			
			$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		}
		else
		{					
			$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		}		
		if (isset($data['itemstate_id']))
		{
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'assignImage')));
		}
		elseif (isset($data['scene_id']))
		{
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignImage')));
		}	
		elseif (isset($data['story_id']))
		{
			$data['assign_image_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'assignImage')));
		}
		//var_dump($data); die();
		$data['add_image_link'] =  View::factory('/admin/image/add',$data)->render();
		$data['images'] = Model_Admin_ImagesAdmin::getImages(array('story_id'=>$data['story_id'],'type_id'=>$data['type_id']));
		$this->template->header = $this->template->top_menu; // move the top menu into the header to save space 
		$this->template->footer = '' ;
		$this->template->top_menu = '' ;
		$this->template->content = View::factory('/admin/image/list',$data)->render();
	}
	
	function action_save()
	{		
		$session = Session::instance('admin');
		$data = Model_Admin_ImagesAdmin::getData();	
		$result = Model_Admin_ImagesAdmin::upload($data);
		$session->set('result',$result);
		if ($result->success)
		{			
			if ($session->get('scene_id'))
			{
				$session->set('image_id',$result->data['image_id']);
			}	
		}
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'list')));	
	}
	
	function action_delete()
	{	
		$session = Session::instance('admin');	
		$session->delete('result');	
		$data = Model_Admin_ImagesAdmin::getData();	
		try
		{
			$dir = APPPATH.MEDIA_PATH.DIRECTORY_SEPARATOR.$data['story_id'].DIRECTORY_SEPARATOR.$data['image_id'].DIRECTORY_SEPARATOR;
			model_utils_dir::remove_directory($dir); // delete images
		}
		catch (Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Unable to Delete '.$dir);
		}
		$result = Model_Admin_ImagesAdmin::getimage()->init($data)->delete();
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
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'image','action'=>'list')));
	}
}

?>
