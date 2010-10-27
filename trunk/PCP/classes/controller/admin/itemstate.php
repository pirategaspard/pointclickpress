<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_itemstate extends Controller_Template_Admin
{	

	function action_edit()
	{		
		$session = Session::instance();	
		$data['item'] = PCPAdmin::getItemDef();		
		$data['itemstate'] = PCPAdmin::getitemstate();
		$data['itemstate_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'save')));		
		$data['itemstate_assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?itemstate_id='.$data['itemstate']->id;			
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemstate_form'] =  View::factory('/admin/itemstate/form',$data)->render();		
		$data['add_itemstate_link'] =  View::factory('/admin/itemstate/add',$data)->render();
		$data['story'] = PCPAdmin::getStory(array('story_id'=>$data['item']->story_id));
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/item/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/itemstate/info',$data)->render();		
		$this->template->top_menu = View::factory('/admin/itemstate/top_menu',$data)->render();						
		$this->template->content = View::factory('/admin/itemstate/template',$data)->render();
	}

	function action_list()
	{	
		$session = Session::instance();	
		$data['scene_id'] = $session->get('scene_id');	
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemstates'] = PCPAdmin::getitemstates(array('item_id'=>$session->get('item_id')));
		$data['assign_itemstate_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'assignImage')));
		$data['add_itemstate_link'] =  View::factory('/admin/itemstate/add',$data)->render();
		
		$this->template->header = '';
		$this->template->top_menu = View::factory('/admin/itemstate/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/itemstate/list',$data)->render();
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
			$itemstate = PCPAdmin::getItemStateByItemId($_POST['item_id'],$_POST['value']);													
			if ((count($itemstate) == 0) || (isset($itemstate[$_POST['id']])))
			{
				$result = PCPAdmin::getitemstate()->init($_POST)->save();
				$session->set('itemstate_id',$result->data['id']);
			}
			else
			{
				$result = new pcpresult(0,'Item State Already Exists');
			}	
		}
		else
		{
			$result = new pcpresult(0,'unable to save Item data');
		}
		if ($result->success)
		{
			// update scene id in session
			$session->set('itemstate_id',$result->data['id']);
			$result->message = "Item State Saved";
		}
		$session->set('result',$result);
		//redirect to edit the Item just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'edit')).'?itemstate_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');
		$result = PCPAdmin::getitemstate()->init(array('id'=>$_REQUEST['itemstate_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Item State Deleted";
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
		if ($session->get('itemstate_id') && $session->get('image_id'))
		{
			$itemstate = PCPAdmin::getitemstate();
			$result = $itemstate->init(array('image_id'=>$session->get('image_id')))->save();
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'edit')));
	}

}

?>