<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Admin_Action extends Controller_Template_Admin
{
	
	function action_index()
	{}
	
	function action_edit()
	{				
		$session = Session::instance();
		$data = Model_Admin_ActionsAdmin::getData();
		/*	
		if ($data['action_type'] == ACTION_TYPE_STORY)
		{
			$data['story'] = Model_Admin_StoriesAdmin::getStoryInfo(array('id'=>$session->get('story_id'),'include_locations'=>true,'include_scenes'=>false));
			$data['story_id'] = $session->get('story_id');
			$data['locations'] = $data['story']->locations;	
		}
		if ($data['action_type'] == ACTION_TYPE_LOCATION)
		{
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
		}
		if ($data['action_type'] == ACTION_TYPE_SCENE)
		{
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
			$data['scene_id'] = $session->get('scene_id');
		}
		*/		
		$data['action'] = Model_Admin_ActionsAdmin::getAction($data);
		$data['action_defs'] = Model_Admin_ActionsAdmin::loadActionTypeActions($data['action_type']);
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['action_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'save')));
		
		$this->template->header = '' ;
		$this->template->scripts = array() ;
		$this->template->top_menu = View::factory('/admin/action/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/action/form',$data)->render();
	}
	
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');
		if(count($_POST) > 0)
		{
			if (isset($_POST['cell_ids']))
			{
				$_POST['cells'] = explode(',',$_POST['cell_ids']);
			}
			// get action label by creating action obj
			$myaction = new $_POST['action'];
			$_POST['action_label'] = $myaction->getLabel();
			//save action
			$result = Model_Admin_ActionsAdmin::getAction($_POST)->load()->init($_POST)->save();		
		}
		else
		{
			$result = new pcpresult(0,'Could not save action');			
		}
		// Create User Message
		if ($result->success)
		{
			$result->message = "Action Saved";
		}
		else
		{
			$result->message = "Action Not Saved";
		}
		$session->set('result',$result);
		//redirect to add a new story
		Request::instance()->redirect($_POST['back_url']);
	}
	
	function action_delete()
	{	
		$session = Session::instance();
		$session->delete('result');
		$back_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$result = Model_Admin_ActionsAdmin::getAction()->init(array('id'=>$_REQUEST['action_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Action Deleted";
		}
		else
		{
			$result->message = "Unable to Delete Action";
		}
		$session->set('result',$result);
		//Go back to the parent
		Request::instance()->redirect($back_url);
	}
	
	function action_list()
	{
		$data = Model_Admin_ActionsAdmin::getData();	
		$data['actions'] = Model_Admin_ActionsAdmin::getActions($data);
		$data['action_add'] = View::factory('/admin/action/add',$data)->render();
		$this->template->content = View::factory('/admin/action/list',$data)->render();	//get action information and load list of actions
	}

	function action_listSimple()
	{
		$this->simple_output();
		$this->action_list();
	}
	
	function action_listGridSimple()
	{
		$this->simple_output();
		$data = Model_Admin_ActionsAdmin::getData();	
		$data['actions'] = Model_Admin_ActionsAdmin::getGridActions($data);
		$this->template->content = View::factory('/admin/action/list_grid',$data)->render();
	}
	
	function action_formGridSimple()
	{
		$this->simple_output();
		$data = Model_Admin_ActionsAdmin::getData();	
		$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene_id'];
		$data['action_defs'] = Model_Admin_ActionsAdmin::loadActionTypeActions(ACTION_TYPE_GRID);						
		$data['locations'] = Model_Admin_LocationsAdmin::getLocations($data);
		$data['action'] = Model_Admin_ActionsAdmin::getAction(array('id'=>$data['id'],'scene_id'=>$data['scene_id'],'action_type'=>ACTION_TYPE_GRID));				
		$data['grid_action_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'save')));									
		$data['action_type'] = ACTION_TYPE_GRID;
		$this->template->content = View::factory('/admin/action/form_grid',$data)->render(); //inline form
	}
}
?>
