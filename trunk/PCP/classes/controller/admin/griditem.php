<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_griditem extends Controller_Template_Admin
{	

	function action_edit()
	{		
		$session = Session::instance('admin');	
		$data = Model_Admin_GriditemAdmin::getData();
		$data['griditem'] = Model_Admin_GriditemAdmin::getGridItem($data);
		$data['scene_id'] = (isset($data['scene_id']))?$data['scene_id']:$data['griditem']->scene_id;
		$data['itemdef_id'] = (isset($data['itemdef_id']))?$data['itemdef_id']:$data['griditem']->itemdef_id;
		$data['story_id'] = (isset($data['story_id']))?$data['story_id']:$data['griditem']->story_id;
		$data['itemdef'] = Model_Admin_ItemDefAdmin::getItemDef(array('id'=>$data['itemdef_id']));		
		$data['story'] = Model_Admin_StoriesAdmin::getStory(array('id'=>$data['story_id'],'creator_user_id'=>$data['creator_user_id']));
		$data['action_list'] = Request::factory('/admin/action/listSimple')->execute()->body();			
		$data['assign_itemdef_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemdef','action'=>'list'))).'?scene_id='.$data['griditem']->scene_id;
		$data['item_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'griditem','action'=>'save')));
		$data['item_form'] =  View::factory('/admin/item/form',$data)->render();
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/itemdef/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/item/info',$data)->render();						
		$this->template->content = View::factory('/admin/item/template',$data)->render();
	}

	function action_list()
	{	
		$session = Session::instance('admin');	
		$data = Model_Admin_GriditemAdmin::getData();	
		$data['story'] = Model_Admin_StoriesAdmin::getStory(array('story_id'=>$data['story_id'],'include_scenes'=>false,'include_locations'=>false,'include_actions'=>false));
		$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		$data['itemdefs'] = Model_Admin_ItemDefAdmin::getItemDefs(array('story_id'=>$data['story_id']));
		$data['assign_item_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignItem')));
		$data['add_item_link'] =  View::factory('/admin/item/add',$data)->render();
		
		$this->template->header = '';
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->content = View::factory('/admin/item/list',$data)->render();
	}

	/*
		save the info from the Item form 
	*/
	function action_save()
	{
		$session = Session::instance('admin');
		$session->delete('result');		
		if(count($_POST) > 0)
		{
			try
			{
				$data = Model_Admin_GriditemAdmin::getData();
				$result = Model_Admin_GriditemAdmin::getGridItem()->init($data)->save();
				$session->set('item_id',$result->data['id']);
			}
			catch (Exception $e)
			{
				Kohana::$log->add(Log::ERROR, 'Unable to Save Griditem');
			}			
		}
		else
		{
			$result = new pcpresult(0,'unable to save Item data');
		}
		if ($result->success)
		{
			// update scene id in session
			$session->set('griditem_id',$result->data['id']);
			$result->message = "Item Saved";
		}
		$session->set('result',$result);
		//redirect to edit the Item just saved
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'griditem','action'=>'edit')).'?griditem_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance('admin');	
		$session->delete('result');		
		$data = Model_Admin_GriditemAdmin::getData();
		try
		{	
			$result = Model_Admin_GriditemAdmin::getGridItem()->init($data)->delete();
		}
		catch (Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Unable to Delete Griditem');
		}
	// Create User Message
		if ($result->success)
		{
			$result->message = "Item Deleted";
		}
		$session->set('result',$result);
		$back_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';	
		//Go back to the parent
		Request::Current()->redirect($back_url);
	}
	
	function action_listSimple()
	{
		$this->simple_output();
		$data = Model_Admin_GriditemAdmin::getData();	
		$data['griditems'] = Model_Admin_GriditemAdmin::getGridItems($data);
		$this->template->content = View::factory('/admin/item/list',$data)->render();
	}
	
	function action_listGridSimple()
	{
		$this->simple_output();
		$data = Model_Admin_GriditemAdmin::getData();	
		$data['griditems'] = Model_Admin_GriditemAdmin::getGridItems($data);
		$this->template->content = View::factory('/admin/item/list_grid',$data)->render();
	}
	
	function action_formGridSimple()
	{
		$this->simple_output();
		$data = Model_Admin_GriditemAdmin::getData();
		/* scene items */
		$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene_id'];
		$data['itemdef'] = Model_Admin_ItemDefAdmin::getItemDef($data);
		$data['griditem'] = Model_Admin_GriditemAdmin::getGridItem($data);		
		$data['scene_id'] = (isset($data['scene_id']))?$data['scene_id']:$data['griditem']->scene_id;
		$data['item_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignItem')));
		$data['assign_itemdef_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemdef','action'=>'list'))).'?scene_id='.$data['scene_id'];
		$this->template->content = $data['griditem_form'] = View::factory('/admin/item/form_grid',$data)->render(); //inline form
	}

}

?>
