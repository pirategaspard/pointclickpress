<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_container extends Controller_Template_Admin
{
	
	function action_index()
	{
		//$this->action_list();
	}
	
	function action_edit()
	{		
		
		$data = EventsAdmin::getUrlParams();
		$data['container'] = PCPAdmin::getContainer(array('include_scenes'=>TRUE,'include_events'=>TRUE));
		$data['story'] = PCPAdmin::getStory(array('id'=>$data['container']->story_id));
		$data['scenes'] = $data['container']->scenes;	
		$data['events'] = $data['container']->events;	
						
		/*
		if (($data['container']->id > 0)&&(count($data['container']->scenes) == 1))
		{
			$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));
			$scenes = $data['container']->scenes;
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id='.reset($scenes)->id);
		}
		
		if (($data['container']->id > 0)&&(count($data['container']->scenes) <= 1))
		{
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id=0');
		}
		else
		{*/
			
		//}		
		
		$data['story_info'] =  View::factory('/admin/story/info',$data)->render();
		
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = View::factory('/admin/event/list',$data)->render();	//get event information and load list of events
		
		$data['scene_add'] = View::factory('/admin/scene/add',$data)->render();
		$data['scene_list'] = View::factory('/admin/scene/list',$data)->render();					
		
		$data['container_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'container','action'=>'save')));		
		$data['container_info'] =  View::factory('/admin/container/info',$data)->render();			
		$data['container_form'] =  View::factory('/admin/container/form',$data)->render();		
				
		$this->template->content = View::factory('/admin/container/template',$data)->render();
	}
	
	function action_save()
	{
		$results = array();
		if(count($_POST) > 0)
		{
			$results = PCPAdmin::getContainer()->init($_POST)->save();
			unset($_POST);
		}
		else
		{
			$results = 'error';
		}
		//redirect to add a new story
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$results['id']);
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getcontainer()->init(array('id'=>$_REQUEST['container_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id='.$_REQUEST['story_id']);
	}
}

?>
