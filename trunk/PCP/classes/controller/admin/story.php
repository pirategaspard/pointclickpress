<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_story extends Controller_Template_Admin
{
	
	function action_index()
	{		
		if (is_numeric($this->request->param('story_id')))
		{
			//redirect to edit story	
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','id'=>$this->request->param('story_id'),'action'=>'edit')));
		}
		else
		{
			$this->action_list();
		}
	}
	
	/*
		List out all stories 
	*/
	function action_list()
	{			
		$data['stories'] = PCPAdmin::getStories(array('include_containers'=>true,'include_scenes'=>true));
		if (count($data['stories']) > 0 )
		{
			$data['story_add'] = View::factory('/admin/story/add',$data)->render();
			$this->template->top_menu = View::factory('/admin/story/top_menu',$data)->render();
			$this->template->content = View::factory('/admin/story/list',$data)->render();
		}
		else
		{	//redirect to add a new story with id 0			
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','id'=>0,'action'=>'edit')));	
		}		
	}
	
	/*
		Show form to edit story 
	*/
	function action_edit()
	{		
		$data = EventsAdmin::getUrlParams();
		$data['story'] = PCPAdmin::getStory(array('include_events'=>true,'include_containers'=>TRUE));
		$data['containers'] = $data['story']->containers;
		$data['events'] = $data['story']->events;				
		
		$data['container_add'] = View::factory('/admin/container/add',$data)->render();
		$data['container_list'] = View::factory('/admin/container/list',$data)->render();	//get container information and load list of containers
		
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = View::factory('/admin/event/list',$data)->render();	//get event information and load list of events
		
		$data['story_info'] =  View::factory('/admin/story/info',$data)->render();
		$data['story_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'save')));			
		$data['story_form'] = View::factory('/admin/story/form',$data)->render();
		
		$this->template->top_menu = View::factory('/admin/story/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/story/template',$data)->render();
	}
	
	/*
		save the info from the story form 
	*/
	function action_save()
	{
		$results = array();
		if(count($_POST) > 0)
		{
			$results = PCPAdmin::getStory()->init($_POST)->save();
			unset($_POST);
		}
		else
		{
			$results = 'error';
		}
		//redirect to edit the story just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id='.$results['id']);
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getStory()->init(array('id'=>$_REQUEST['story_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')));
	}

}

?>
