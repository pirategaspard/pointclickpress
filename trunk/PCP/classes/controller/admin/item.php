<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_item extends Controller_Template_Admin
{	

	function action_edit()
	{		
		$session = Session::instance();	
		$data['item'] = PCPAdmin::getItemDef();
		$data['item_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'save')));		
		$data['item_assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?scene_id='.$session->get('scene_id').'&item_id='.$data['item']->id;			
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['item_form'] =  View::factory('/admin/item/form',$data)->render();		
		$data['add_item_link'] =  View::factory('/admin/item/add',$data)->render();
		$data['story'] = PCPAdmin::getStory(array('story_id'=>$data['item']->story_id));
		$data['event_list'] = Request::factory('/admin/event/listSimple')->execute()->response;			
		$data['itemstate_list'] = Request::factory('/admin/itemstate/listSimple')->execute()->response;
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/item/info',$data)->render();		
		$this->template->top_menu = View::factory('/admin/item/top_menu',$data)->render();						
		$this->template->content = View::factory('/admin/item/template',$data)->render();
	}

	function action_list()
	{	
		$session = Session::instance();	
		$data['story_id'] = $session->get('story_id');
		$data['scene_id'] = $session->get('scene_id');	
		$data['story'] = PCPAdmin::getStory(array('story_id'=>$data['story_id'],'include_scenes'=>false,'include_locations'=>false,'include_events'=>false));
		//var_dump($data); die();
		$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		$data['items'] = PCPAdmin::getItemDefs(array('story_id'=>$data['story_id']));
		$data['assign_item_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignItem')));
		$data['add_item_link'] =  View::factory('/admin/item/add',$data)->render();
		
		$this->template->header = '';
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->top_menu = View::factory('/admin/item/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/item/list',$data)->render();
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
			$result = PCPAdmin::getItemDef()->init($_POST)->save();
			$session->set('item_id',$result->data['id']);			
		}
		else
		{
			$result = new pcpresult(0,'unable to save Item data');
		}
		if ($result->success)
		{
			// update scene id in session
			$session->set('item_id',$result->data['id']);
			$result->message = "Item Saved";
		}
		$session->set('result',$result);
		//redirect to edit the Item just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'item','action'=>'edit')).'?item_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');
		$result = PCPAdmin::getItemDef()->init(array('id'=>$_REQUEST['item_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Item Deleted";
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
		if ($session->get('item_id') && $session->get('image_id'))
		{
			$item = PCPAdmin::getItem();
			$result = $item->init(array('image_id'=>$session->get('image_id')))->save();
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'item','action'=>'edit')));
	}
	
	function action_listSimple()
	{
		$this->simple_output();
		$data = ItemAdmin::getData();	
		$data['items'] = ItemAdmin::getItems($data);
		$data['item_add'] = View::factory('/admin/item/add',$data)->render();
		$this->template->content = View::factory('/admin/item/list',$data)->render();
	}
	
	function action_listGridSimple()
	{
		$this->simple_output();
		$data = ItemAdmin::getData();	
		$data['items'] = ItemAdmin::getItems($data);
		$this->template->content = View::factory('/admin/item/list_grid',$data)->render();
	}
	
	function action_formGridSimple()
	{
		$this->simple_output();
		$data = ItemAdmin::getData();
		/* scene items */
		if (1 == 1)
		{
			$session = Session::instance();
			$session->delete('image_id');			
		}
		$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene_id'];
		$data['item'] = PCPAdmin::getItemDef(array('scene_id'=>$data['scene_id']));
		$data['griditem'] = PCPAdmin::getGridItem(array('scene_id'=>$data['scene_id']));			
		$data['item_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignItem')));;
		$data['assign_item_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'list'))).'?scene_id='.$session->get('scene_id');//.'&grid_item_id='.$data['griditem']->id;
		$this->template->content = View::factory('/admin/item/form_grid',$data)->render(); //inline form
	}

}

?>
