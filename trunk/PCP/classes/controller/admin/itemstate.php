<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_itemstate extends Controller_Template_Admin
{	
	function action_edit()
	{		
		$session = Session::instance('admin');	
		$data = Model_Admin_ItemstateAdmin::getData();	
		$data['itemstate'] = Model_Admin_ItemstateAdmin::getitemstate(array('id'=>$data['itemstate_id']));
		$data['itemdef_id'] = (isset($data['itemdef_id']))?$data['itemdef_id']:$data['itemstate']->itemdef_id;
		$data['itemdef'] = Model_Admin_ItemDefAdmin::getItemDef(array('id'=>$data['itemdef_id']));	
		$data['story_id'] = (isset($data['story_id']))?$data['story_id']:$data['itemdef']->story_id;
		$data['itemstate_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'save')));		
		$data['itemstate_assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?itemstate_id='.$data['itemstate']->id;			
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemstate_form'] =  View::factory('/admin/itemstate/form',$data)->render();		
		$data['add_itemstate_link'] =  View::factory('/admin/itemstate/add',$data)->render();
		$data['story'] = Model_Admin_StoriesAdmin::getStory(array('id'=>$data['itemdef']->story_id,'creator_user_id'=>$data['creator_user_id']));
		$data['action_list'] = Request::factory('/admin/action/listSimple')->execute()->body();
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/itemdef/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/itemstate/info',$data)->render();							
		$this->template->content = View::factory('/admin/itemstate/template',$data)->render();
	}

	function action_list()
	{	
		$session = Session::instance('admin');	
		$data = Model_Admin_ItemstateAdmin::getData();	
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['itemstates'] = Model_Admin_ItemstateAdmin::getItemstates(array('itemdef_id'=>$session->get('itemdef_id')));
		$data['assign_itemstate_url'] = Url::site(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'assignImage')));
		$data['add_itemstate_link'] =  View::factory('/admin/itemstate/add',$data)->render();
		
		$this->template->header = '';
		$this->template->content = View::factory('/admin/itemstate/list',$data)->render();
	}

	/*
		save the info from the Item form 
	*/
	function action_save()
	{
		$session = Session::instance('admin');
		$session->delete('result');	
		$data = Model_Admin_ItemstateAdmin::getData();		
		if(count($_POST) > 0)
		{
			$data = Model_Admin_ItemstateAdmin::getData();
			$itemstate = Model_Admin_ItemstateAdmin::getItemStateByItemId($_POST['itemdef_id'],$_POST['value']);													
			if ((count($itemstate) == 0) || (isset($itemstate[$_POST['id']])))
			{
				try
				{
					$data = Model_Admin_ItemstateAdmin::getData();
					$result = Model_Admin_ItemstateAdmin::getitemstate()->init($data)->save();
					$session->set('itemstate_id',$result->data['id']);
				}
				catch (Exception $e)
				{
					Kohana::$log->add(Log::ERROR, 'Unable to Save ItemState');
				}
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
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'edit')).'?itemstate_id='.$result->data['id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance('admin');	
		$session->delete('result');
		try
		{
			$data = Model_Admin_ItemstateAdmin::getData();
			$result = Model_Admin_ItemstateAdmin::getitemstate()->init($data)->delete();
		}
		catch (Exception $e)
		{
			Kohana::$log->add(Log::ERROR, 'Unable to Delete ItemState');
		}
		// Create User Message
		if ($result->success)
		{
			$result->message = "Item State Deleted";
		}
		$session->set('result',$result);
		$back_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';	
		//Go back to the parent
		Request::Current()->redirect($back_url);
	}
	
	function action_assignImage()
	{		
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_ItemstateAdmin::getData();			
		if (isset($data['itemstate_id']) && isset($data['image_id']))
		{
			try
			{
				$itemstate = Model_Admin_ItemstateAdmin::getItemstate(array('id'=>$data['itemstate_id']));
				$result = $itemstate->init(array('image_id'=>$data['image_id']))->save();
			}
			catch (Exception $e)
			{
				Kohana::$log->add(Log::ERROR, 'Unable to Assign Image to ItemState');
			}
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'itemstate','action'=>'edit')).'?itemstate_id='.$data['itemstate_id']);
	}

	function action_listSimple()
	{
		$this->simple_output();
		$data = Model_Admin_ItemstateAdmin::getData();	
		$data['itemstates'] = Model_Admin_ItemstateAdmin::getItemstates($data);
		$data['itemstate_add'] = View::factory('/admin/itemstate/add',$data)->render();
		$this->template->content = View::factory('/admin/itemstate/list',$data)->render();
	}
	
}

?>
