<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_story extends Controller_Template_Admin
{
	
	function action_index()
	{		
		if (is_numeric($this->request->param('story_id')))
		{
			//redirect to edit story	
			Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')));
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
		Model_Admin_ActionDefsAdmin::searchForListeners(); // search for new ActionDefs
		Model_Admin_PluginsAdmin::searchForListeners(); // search for new Plugins
		$data = Model_Admin_StoriesAdmin::GetData();
		$data['stories'] = Model_Admin_StoriesAdmin::getStories($data);
		if (count($data['stories']) > 0 )
		{
			$data['story_add'] = View::factory('/admin/story/add',$data)->render();
			$this->template->top_menu = View::factory('/admin/story/top_menu',$data)->render();
			$this->template->content = View::factory('/admin/story/list',$data)->render();
		}
		else
		{	//redirect to add a new story with id 0			
			Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id=0');	
		}		
	}
	
	/*
		Show form to edit story 
	*/
	function action_edit()
	{		
		$session = Session::instance('admin');
		$data = Model_Admin_StoriesAdmin::GetData();
		$data['story'] = Model_Admin_StoriesAdmin::getStory($data);
		// check to make sure the correct user is accessing the correct story, or is creating a new story
		if (($data['story']->creator_user_id > 0) && ($data['story']->creator_user_id != $data['user_id']) && ($data['story_id']!= 0))
		{		
			//redirect to add a new story with id 0			
			Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id=0');
		}
		else
		{
			if ($data['story']->id == 0)
			{
				$data['story']->setCreatorUserId($data['creator_user_id']);
			}
			
			$session->set('story_id',$data['story_id']);
			$session->delete('location_id'); // if id exits, delete it.
			
			$data['locations'] = Model_Admin_LocationsAdmin::getLocations($data); // needed to choose starting location
			$data['grid_sizes'] = explode(',',SUPPORTED_GRID_SIZES);
	
			$data['action_list'] = Request::factory('/admin/action/listSimple')->execute()->body();
			$data['item_list'] = Request::factory('/admin/itemdef/listSimple')->execute()->body();	
			$data['location_list'] = Request::factory('/admin/location/listSimple')->execute()->body();
			$data['plugin_list'] = Request::factory('/admin/storyplugin/liststoryplugins')->execute()->body();		
							
			$data['story_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'story','action'=>'save')));
			$data['assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?story_id='.$data['story']->id;
			$data['story_form'] = View::factory('/admin/story/form',$data)->render();
			
			$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
			$this->template->top_menu = View::factory('/admin/story/top_menu',$data)->render();
			$this->template->content = View::factory('/admin/story/template',$data)->render();
		}
	}
	
	/*
		save the info from the story form 
	*/
	function action_save()
	{
		$session = Session::instance('admin');
		$session->delete('result');
		if(count($_POST) > 0)
		{
			$result = Model_Admin_StoriesAdmin::getStory()->init($_POST)->save();
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
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id='.$session->get('story_id',0));
	}
	
	function action_assignImage()
	{		
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_StoriesAdmin::GetData();			
		if (isset($data['story_id']) && isset($data['image_id']))
		{
			$story = Model_Admin_StoriesAdmin::getStory($data);
			$result = $story->init(array('image_id'=>$data['image_id']))->save();
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')).'?story_id='.$data['story_id']);
	}
	
	function action_delete()
	{	
		$session = Session::instance('admin');	
		$session->delete('result');	
		$data = Model_Admin_StoriesAdmin::GetData();
		$result = Model_Admin_StoriesAdmin::getStory()->init(array('id'=>$data['story_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			//$result->message = "Story Deleted";
		}
		elseif($result->success == 0)
		{
			//$result->message = "Unable to Delete Story";
		}
		$session->set('result',$result);	
		//Go back to the parent
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'list')));
	}

}

?>
