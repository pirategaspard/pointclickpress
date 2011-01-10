<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_event extends Controller_Template_Admin
{
	
	function action_index()
	{}
	
	function action_edit()
	{				
		$session = Session::instance();
		$data['event_type'] = EventsAdmin::getEventType();	
		if ($data['event_type'] == 'story')
		{
			$data['story'] = PCPAdmin::getStoryInfo(array('id'=>$session->get('story_id'),'include_locations'=>true,'include_scenes'=>false));
			$data['story_id'] = $session->get('story_id');
			$data['locations'] = $data['story']->locations;	
		}
		if ($data['event_type'] == 'location')
		{
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
		}
		if ($data['event_type'] == 'scene')
		{
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
			$data['scene_id'] = $session->get('scene_id');
		}
		if ($data['event_type'] == 'itemstate')
		{
			/* $data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
			$data['scene_id'] = $session->get('scene_id'); */
			$data['itemstate_id'] = $session->get('itemstate_id');
		}					
		$data['event'] = PCPAdmin::getEvent();
		$data['event_defs'] = PCPAdmin::loadEventDefs();
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
			$result = EventsAdmin::getEvent($_POST)->load()->init($_POST)->save();		
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
		$result = EventsAdmin::getEvent()->init(array('id'=>$_REQUEST['event_id']))->delete();
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
		$data = EventsAdmin::getData();	
		$data['events'] = EventsAdmin::getEvents($data);
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
		$data = EventsAdmin::getData();	
		$data['events'] = EventsAdmin::getGridEvents($data);
		$this->template->content = View::factory('/admin/event/list_grid',$data)->render();
	}
	
	function action_formGridSimple()
	{
		$this->simple_output();
		$data = EventsAdmin::getData();	
		$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene_id'];
		$data['event_defs'] = PCPAdmin::loadEventDefs();						
		//$data['locations'] = $data['story']->locations;
		$data['locations'] = PCPAdmin::getLocations($data);
		$data['event'] = PCPAdmin::getEvent(array('scene_id'=>$data['scene_id'],'event_type'=>'grid'));				
		$data['grid_event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));									
		$data['event_type'] = 'grid';
		$this->template->content = View::factory('/admin/event/form_grid',$data)->render(); //inline form
	}
}
?>
