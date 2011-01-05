<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_location extends Controller_Template_Admin
{
	
	function action_index()
	{
		//$this->action_list();
	}
	
	function action_edit()
	{		
		$data['location'] = PCPAdmin::getlocation(array('include_scenes'=>TRUE,'include_events'=>false));
		$data['story'] = PCPAdmin::getStory(array('id'=>$data['location']->story_id));
		$data['scenes'] = $data['location']->scenes;			
		
		// if there is only one scene in a location redirect to scene edit
		/*
		if (($data['location']->id > 0)&&(count($data['location']->scenes) == 1))
		{
			$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));
			$scenes = $data['location']->scenes;
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.reset($scenes)->id);
		}
		*/
		
		// if there is no scene in a location redirect to add a scene
		if (($data['location']->id > 0)&&(count($data['location']->scenes) < 1))
		{
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id=0');
		}
		else
		{			
			$data['event_list'] = Request::factory('/admin/event/listSimple')->execute()->response;	
			$data['scene_list'] = Request::factory('/admin/scene/listSimple')->execute()->response;					
			
			$data['location_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'location','action'=>'save')));					
			$data['location_form'] =  View::factory('/admin/location/form',$data)->render();		
	
			$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
			$this->template->breadcrumb .= View::factory('/admin/location/info',$data)->render();				
			$this->template->content = View::factory('/admin/location/template',$data)->render();
		}
	}
	
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');
		if(count($_POST) > 0)
		{
			$result = PCPAdmin::getlocation()->init($_POST)->save();
			$session->set('location_id',$result->data['id']);
		}
		else
		{
			$result = new pcpresult(0,'unable to save location data');
		}
		// Create User Message
		if ($result->success)
		{
			$result->message = "Location Saved";
		}
		$session->set('result',$result);
		
		//redirect to add a new story
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
	}
	
	function action_delete()
	{	
		$session = Session::instance();
		$session->delete('result');	
		$result = PCPAdmin::getlocation()->init(array('id'=>$_REQUEST['location_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Location Deleted";
		}
		elseif($result->success == 0)
		{
			$result->message = "Unable to Delete Location";
		}
		$session->set('result',$result);
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'story','action'=>'edit')));
	}
	
	function action_listSimple()
	{
		$this->simple_output();
		$this->action_list();
	}
	
	function action_list()
	{
		$data = LocationAdmin::getData();	
		$data['locations'] = LocationAdmin::getLocations($data);
		$data['location_add'] = View::factory('/admin/location/add',$data)->render();
		$this->template->content = View::factory('/admin/location/list',$data)->render();	//get location information and load list of locations
	}
}

?>
