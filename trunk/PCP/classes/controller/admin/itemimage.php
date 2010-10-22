<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_itemimage extends Controller_Template_Admin
{	

	function action_edit()
	{		
		$session = Session::instance();	
		$data['item'] = PCPAdmin::getItem();		
		$data['itemimage'] = PCPAdmin::getItemImage();
		$data['itemimage_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemimage','action'=>'save')));		
		$data['itemimage_assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?itemimage_id='.$data['itemimage']->id;			
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemimage_form'] =  View::factory('/admin/itemimage/form',$data)->render();		
		$data['add_itemimage_link'] =  View::factory('/admin/itemimage/add',$data)->render();
		$data['story'] = PCPAdmin::getStory(array('story_id'=>$data['item']->story_id));
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/item/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/itemimage/info',$data)->render();		
		$this->template->top_menu = View::factory('/admin/itemimage/top_menu',$data)->render();						
		$this->template->content = View::factory('/admin/itemimage/template',$data)->render();
	}



	function action_list()
	{	
		$session = Session::instance();	
		$data['scene_id'] = $session->get('scene_id');	
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemimages'] = PCPAdmin::getItems(array('item_id'=>$session->get('item_id')));
		$data['assign_itemimage_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemimage','action'=>'assignImage')));
		$data['add_itemimage_link'] =  View::factory('/admin/itemimage/add',$data)->render();
		
		$this->template->header = '';
		$this->template->top_menu = View::factory('/admin/itemimage/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/itemimage/list',$data)->render();
	}


	/*
		save the info from the Item form 
	*/
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');		
		if(count($_POST) > 0)
		{
			$result = PCPAdmin::getItemImage()->init($_POST)->save();
			$session->set('itemimage_id',$result->data['id']);			
		}
		else
		{
			$result = new pcpresult(0,'unable to save Item data');
		}
		if ($result->success)
		{
			// update scene id in session
			$session->set('itemimage_id',$result->data['id']);
			$result->message = "Item Image Saved";
		}
		$session->set('result',$result);
		//redirect to edit the Item just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'itemimage','action'=>'edit')).'?itemimage_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');
		$result = PCPAdmin::getItemImage()->init(array('id'=>$_REQUEST['itemimage_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Item Image Deleted";
		}
		$session->set('result',$result);
		$back_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';	
		//Go back to the parent
		Request::instance()->redirect($back_url);
	}
	
	function action_assignImage()
	{		
		$session = Session::instance();	
		$session->delete('result');
		PCPAdmin::getArgs();			
		if ($session->get('itemimage_id') && $session->get('image_id'))
		{
			$itemimage = PCPAdmin::getItemImage();
			$result = $itemimage->init(array('image_id'=>$session->get('image_id')))->save();
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'itemimage','action'=>'edit')));
	}

}

?>