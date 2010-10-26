<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_story extends Controller_Template_Admin
{
	
	function action_index()
	{		
		if (is_numeric($this->request->param('story_id')))
		{
			//redirect to edit story	
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')));
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
		$data['stories'] = PCPAdmin::getStories(array('include_locations'=>true,'include_scenes'=>true));
		if (count($data['stories']) > 0 )
		{
			$data['story_add'] = View::factory('/admin/story/add',$data)->render();
			$this->template->top_menu = View::factory('/admin/story/top_menu',$data)->render();
			$this->template->content = View::factory('/admin/story/list',$data)->render();
		}
		else
		{	//redirect to add a new story with id 0			
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id=0');	
		}		
	}
	
	/*
		Show form to edit story 
	*/
	function action_edit()
	{		
		$data['type'] = EventsAdmin::getEventType();
		$data['story'] = PCPAdmin::getStory(array('include_events'=>true,'include_locations'=>TRUE));
		$data['locations'] = $data['story']->locations;
		$data['events'] = $data['story']->events;
		$data['items'] = PCPAdmin::getItemDefs(array('story_id'=>$data['story']->id));	
		$data['grid_sizes'] = explode(',',SUPPORTED_GRID_SIZES);
		
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = View::factory('/admin/event/list',$data)->render();	//get event information and load list of events
		
		$data['location_add'] = View::factory('/admin/location/add',$data)->render();
		$data['location_list'] = View::factory('/admin/location/list',$data)->render();	//get location information and load list of locations
		
		$data['item_add'] = View::factory('/admin/item/add',$data)->render();
		$data['item_list'] = View::factory('/admin/item/list',$data)->render();
						
		$data['story_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'save')));
		$data['assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?story_id='.$data['story']->id;
		$data['story_form'] = View::factory('/admin/story/form',$data)->render();
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->top_menu = View::factory('/admin/story/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/story/template',$data)->render();
	}
	
	/*
		save the info from the story form 
	*/
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');
		if(count($_POST) > 0)
		{
			$result = PCPAdmin::getStory()->init($_POST)->save();
			$session->set('story_id',$result->data['id']);			
		}
		else
		{
			$result = new pcpresult(0,'unable to save story data');
		}
		if ($result->success)
		{
			$result->message = "Story Saved";
		}
		$session->set('result',$result);
		//redirect to edit the story just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')));
	}
	
	function action_assignImage()
	{		
		$session = Session::instance();	
		$session->delete('result');
		PCPAdmin::getArgs();			
		if ($session->get('story_id') && $session->get('image_id'))
		{
			$story = PCPAdmin::getStory();
			$result = $story->init(array('image_id'=>$session->get('image_id')))->save();
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')));
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');	
		$result = PCPAdmin::getStory()->init(array('id'=>$_REQUEST['story_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Scene Deleted";
		}
		elseif($result->success == 0)
		{
			$result->message = "Unable to Delete Scene";
		}
		$session->set('result',$result);	
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')));
	}

}

?>
