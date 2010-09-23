<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_event extends Controller_Template_Admin
{
	
	function action_index()
	{
		//$this->event_list();
	}
	
	function action_list()
	{
		/*		
		$this->auto_render = FALSE; // disable auto render
		
		$data = $this->getUrl_params();
		
		$this->template->content = View::factory('/admin/event/list',$data)->render();	//get event information and load list of events	
		*/
	}
	
	function action_edit()
	{				
		/*
		$data['containers'] = $data['story']->containers;
		$data['container'] = $data['story']->containers[$_REQUEST['container_id']];
		*/
		$session = Session::instance();
		$data['type'] = EventsAdmin::getEventType();		
		if (isset($data['type']) && $data['type'] == 'story')
		{
			$data['story'] = PCPAdmin::getStoryInfo(array('id'=>$session->get('story_id'),'include_containers'=>true,'include_scenes'=>false));
			$data['containers'] = $data['story']->containers;	
		}
			
		$data['event'] = PCPAdmin::getEvent();
		$data['event_types'] = PCPAdmin::loadEventTypes();
		$data['back_url'] = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$data['event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));
		
		$this->template->header = '' ;
		$this->template->top_menu = View::factory('/admin/event/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/event/form',$data)->render();
		//Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id='.$_REQUEST['scene_id'].'&event_id='.$_REQUEST['event_id']);
	}
	
	function action_save()
	{
		$session = Session::instance();
		$results = array();
		$session->set('results',$results);
		if(count($_POST) > 0)
		{
			$data['type'] = EventsAdmin::getEventType();
			if (isset($_POST['cell_ids']))
			{
				$_POST['cells'] = explode(',',$_POST['cell_ids']);
			}
			// get event label by creating event obj
			$myevent = new $_POST['event'];
			$_POST['event_label'] = $myevent->getLabel();
			//save event
			$results = EventsAdmin::getEvent($data)->init($_POST)->save();	
			$session->set('results',$results);	
			unset($_POST);
		}
		else
		{
				$results['success'] = 0;
				$results['message'] = 'Could not save event';
				$session->set('results',$results);
		}
		//redirect to add a new story
		Request::instance()->redirect($_POST['back_url']);
	}
	
	function action_delete()
	{	
		$back_url = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
		$results = EventsAdmin::getEvent()->init(array('id'=>$_REQUEST['event_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect($back_url);
	}
}
?>
