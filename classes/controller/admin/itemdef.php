<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_itemdef extends Controller_Template_Admin
{	

	function action_edit()
	{		
		$session = Session::instance('admin');	
		$session->delete('itemstate_id'); // if id exits, delete it.
		$session->delete('scene_id'); // if id exits, delete it.
		$data = Model_Admin_ItemDefAdmin::getData();
		$data['itemdef'] = Model_Admin_ItemDefAdmin::getItemDef($data);
		$data['story_id'] = (isset($data['story_id']))?$data['story_id']:$data['itemdef']->story_id;
		$data['itemdef_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemdef','action'=>'save')));		
		$data['itemdef_assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?itemdef_id='.$data['itemdef']->id;			
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemdef_form'] =  View::factory('/admin/itemdef/form',$data)->render();		
		$data['add_itemdef_link'] =  View::factory('/admin/itemdef/add',$data)->render();
		$data['story'] = Model_Admin_StoriesAdmin::getStory(array('id'=>$data['story_id'],'creator_user_id'=>$data['creator_user_id']));
		$data['action_list'] = Request::factory('/admin/action/listSimple')->execute()->body();			
		$data['itemstate_list'] = Request::factory('/admin/itemstate/listSimple')->execute()->body();
		$data['iteminstances_list'] = Request::factory('/admin/griditem/listSimple')->execute()->body();
		$session->set('story_id',$data['story_id']);		
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/itemdef/info',$data)->render();							
		$this->template->content = View::factory('/admin/itemdef/template',$data)->render();
	}

	function action_list()
	{	
		$session = Session::instance('admin');	
		$data = Model_Admin_ItemDefAdmin::getData();
		$data['story'] = Model_Admin_StoriesAdmin::getStory(array('story_id'=>$data['story_id'],'include_scenes'=>false,'include_locations'=>false,'include_actions'=>false));
		$data['back_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		$data['itemdefs'] = Model_Admin_ItemDefAdmin::getItemDefs(array('story_id'=>$data['story_id']));
		$data['assign_itemdef_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignItem')));
		$data['add_itemdef_link'] =  View::factory('/admin/itemdef/add',$data)->render();
		
		$this->template->header = '';
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->content = View::factory('/admin/itemdef/list',$data)->render();
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
			$data = Model_Admin_ItemDefAdmin::getData();
			$result = Model_Admin_ItemDefAdmin::getItemDef()->init($data)->save();
			$session->set('itemdef_id',$result->data['id']);	
		}
		else
		{
			$result = new pcpresult(0,'unable to save Item data');
		}
		$session->set('result',$result);
		//redirect to edit the Item just saved
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'itemdef','action'=>'edit')).'?itemdef_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_ItemDefAdmin::getData();
		$result = Model_Admin_ItemDefAdmin::getItemDef()->init($data)->delete();
		$session->set('result',$result);
		$back_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';	
		//Go back to the parent
		Request::Current()->redirect($back_url);
	}
	
	function action_listSimple()
	{
		$this->simple_output();
		$data = Model_Admin_ItemDefAdmin::getData();	
		$data['itemdefs'] = Model_Admin_ItemDefAdmin::getItemDefs($data);
		$data['itemdef_add'] = View::factory('/admin/itemdef/add',$data)->render();
		$this->template->content = View::factory('/admin/itemdef/list',$data)->render();
	}

}

?>
