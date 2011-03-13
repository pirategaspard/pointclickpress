<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_event extends Controller_Template_Admin
{
	
	function action_index()
	{}
	
	function action_edit()
	{				
		$session = Session::instance();
		$data = Model_Admin_EventsAdmin::getData();
		/*	
		if ($data['event_type'] == EVENT_TYPE_STORY)
		{
			$data['story'] = Model_Admin_StoriesAdmin::getStoryInfo(array('id'=>$session->get('story_id'),'include_locations'=>true,'include_scenes'=>false));
			$data['story_id'] = $session->get('story_id');
			$data['locations'] = $data['story']->locations;	
		}
		if ($data['event_type'] == EVENT_TYPE_LOCATION)
		{
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
		}
		if ($data['event_type'] == EVENT_TYPE_SCENE)
		{
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
			$data['scene_id'] = $session->get('scene_id');
		}
		*/		
		$data['event'] = Model_Admin_EventsAdmin::getEvent($data);
		$data['event_defs'] = Model_Admin_EventsAdmin::loadEventTypeEventDefs($data['event_type']);
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));
		
		$this->template->header = '' ;
		$this->template->scripts = array() ;
		$this->template->top_menu = View::factory('/admin/event/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/event/form',$data)->render();
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
			// get event label by creating event obj
			$myevent = new $_POST['event'];
			$_POST['event_label'] = $myevent->getLabel();
			//save event
			$result = Model_Admin_EventsAdmin::getEvent($_POST)->load()->init($_POST)->save();		
		}
		else
		{
			$result = new pcpresult(0,'Could not save event');			
		}
		// Create User Message
		if ($result->success)
		{
			$result->message = "Event Saved";
		}
		else
		{
			$result->message = "Event Not Saved";
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
		$result = Model_Admin_EventsAdmin::getEvent()->init(array('id'=>$_REQUEST['event_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Event Deleted";
		}
		else
		{
			$result->message = "Unable to Delete Event";
		}
		$session->set('result',$result);
		//Go back to the parent
		Request::instance()->redirect($back_url);
	}
	
	function action_list()
	{
		$data = Model_Admin_EventsAdmin::getData();	
		$data['events'] = Model_Admin_EventsAdmin::getEvents($data);
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$this->template->content = View::factory('/admin/event/list',$data)->render();	//get event information and load list of events
	}

	function action_listSimple()
	{
		$this->simple_output();
		$this->action_list();
	}
	
	function action_listGridSimple()
	{
		$this->simple_output();
		$data = Model_Admin_EventsAdmin::getData();	
		$data['events'] = Model_Admin_EventsAdmin::getGridEvents($data);
		$this->template->content = View::factory('/admin/event/list_grid',$data)->render();
	}
	
	function action_formGridSimple()
	{
		$this->simple_output();
		$data = Model_Admin_EventsAdmin::getData();	
		$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene_id'];
		$data['event_defs'] = Model_Admin_EventsAdmin::loadEventTypeEventDefs(EVENT_TYPE_GRID);						
		$data['locations'] = Model_Admin_LocationsAdmin::getLocations($data);
		$data['event'] = Model_Admin_EventsAdmin::getEvent(array('id'=>$data['id'],'scene_id'=>$data['scene_id'],'event_type'=>EVENT_TYPE_GRID));				
		$data['grid_event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));									
		$data['event_type'] = EVENT_TYPE_GRID;
		$this->template->content = View::factory('/admin/event/form_grid',$data)->render(); //inline form
	}
}
?>
