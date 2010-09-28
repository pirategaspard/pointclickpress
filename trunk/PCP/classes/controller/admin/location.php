<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_location extends Controller_Template_Admin
{
	
	function action_index()
	{
		//$this->action_list();
	}
	
	function action_edit()
	{		
		$data['type'] = EventsAdmin::getEventType();
		$data['location'] = PCPAdmin::getlocation(array('include_scenes'=>TRUE,'include_events'=>TRUE));
		$data['story'] = PCPAdmin::getStory(array('id'=>$data['location']->story_id));
		$data['scenes'] = $data['location']->scenes;	
		$data['events'] = $data['location']->events;	
						
		/*
		if (($data['location']->id > 0)&&(count($data['location']->scenes) == 1))
		{
			$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));
			$scenes = $data['location']->scenes;
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&location_id='.$_REQUEST['location_id'].'&scene_id='.reset($scenes)->id);
		}
		
		if (($data['location']->id > 0)&&(count($data['location']->scenes) <= 1))
		{
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&location_id='.$_REQUEST['location_id'].'&scene_id=0');
		}
		else
		{*/
			
		//}		
		
		$data['story_info'] =  View::factory('/admin/story/info',$data)->render();
		
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = View::factory('/admin/event/list',$data)->render();	//get event information and load list of events
		
		$data['scene_add'] = View::factory('/admin/scene/add',$data)->render();
		$data['scene_list'] = View::factory('/admin/scene/list',$data)->render();					
		
		$data['location_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'location','action'=>'save')));		
		$data['location_info'] =  View::factory('/admin/location/info',$data)->render();			
		$data['location_form'] =  View::factory('/admin/location/form',$data)->render();		
				
		$this->template->content = View::factory('/admin/location/template',$data)->render();
	}
	
	function action_save()
	{
		$session = Session::instance();
		$results = array();
		$session->set('results',$results);
		if(count($_POST) > 0)
		{
			$results = PCPAdmin::getlocation()->init($_POST)->save();
			$session->set('location_id',$results['id']);
			unset($_POST);
		}
		else
		{
			$results = 'error';
		}
		
		$session->set('results',$results);
		
		//redirect to add a new story
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getlocation()->init(array('id'=>$_REQUEST['location_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')));
	}
}

?>
