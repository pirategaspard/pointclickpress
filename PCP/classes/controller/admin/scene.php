<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_scene extends Controller_Template_Admin
{
	
	function action_edit()
	{	
		$session = Session::instance();
	
		// if we have a new scene, reset the image_id to zero
		if ((isset($_REQUEST['scene_id'])) && ($_REQUEST['scene_id'] == 0))
		{
			$session->set('image_id',0);			
		}
						
		$data['type'] = EventsAdmin::getEventType();
		$data['scene'] = PCPAdmin::getScene(array('include_events'=>true));		
		$data['story'] = PCPAdmin::getStoryInfo(array('id'=>$data['scene']->story_id,'include_locations'=>true,'include_scenes'=>false));
		$data['location'] = $data['story']->locations[$data['scene']->location_id];
		$data['events'] = $data['scene']->events;						
				
		// set the scene title equal to the parent location title if the scene title is empty, else set it to itself
		$data['scene']->setTitle((strlen($data['scene']->title)>0) ? $data['scene']->title : $data['location']->title); //if (strlen($data['scene']->title)==0) $data['scene']->setTitle($data['location']->title);
		// set the story size 
		$data['story']->setDimensions(800,600);
		$data['assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?story_id='.$data['scene']->story_id.'&location_id='.$data['scene']->location_id.'&scene_id='.$session->get('scene_id');
		
		$data['story_info'] =  View::factory('/admin/story/info',$data)->render();
		$data['location_info'] =  View::factory('/admin/location/info',$data)->render();
		$data['scene_info'] =  View::factory('/admin/scene/info',$data)->render();
		$data['scene_add'] =  View::factory('/admin/scene/add',$data)->render();
		
		/* scene events */			
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = EventsAdmin::getEventsList(array('events'=>$data['scene']->events));				
		
		/* scene */
		$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));						
		$data['scene_form'] = View::factory('/admin/scene/form',$data)->render();
						
		if (strlen($data['scene']->filename) > 0)
		{
			/* grid events */
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
			$data['scene_id'] = $session->get('scene_id');
			
			$data['event_types'] = PCPAdmin::loadEventTypes();						
			$data['locations'] = $data['story']->locations;
			$data['event'] = PCPAdmin::getEvent(array('scene_id'=>$data['scene']->id,'type'=>'Grid'));				
			//$data['grid_event_add'] = View::factory('/admin/event/add',$data)->render(); //inline form
			$data['grid_event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));
			$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene']->id;						
			$data['type'] = 'Grid';
			$data['grid_event_form'] = View::factory('/admin/event/form_grid',$data)->render(); //inline form
			$data['grid_event_list'] = EventsAdmin::getEventsList(array('events'=>$data['scene']->grid_events,'type'=>$data['type']));		
			
			/* Grid */
			$data['grid'] = View::factory('/admin/scene/grid',$data)->render();
		}
		else
		{
			$data['grid'] = '';
		}
		
		$this->template->content = View::factory('/admin/scene/template',$data)->render();
	}
	
	function action_save()
	{
		$session = Session::instance();		
		$results = array();
		$session->set('results',$results);
		if(count($_POST) > 0)
		{
			$results['success'] = 1;
			
			// if we don't have a scene location yet we must create one
			if ((!isset($_POST['location_id'])) ||(strlen($_POST['location_id'])<=0)||($_POST['location_id']<=0))
			{	
				$results = PCPAdmin::getlocation()->init($_POST)->save();
				$_POST['location_id'] = $results['id'];
			}				
			if ($results['success'])
			{				
				//check for duplicates
				if ($session->get('scene_id') == 0)
				{
					// check that there is not already a scene in this location with this value
					$scene = PCPAdmin::getSceneBylocationId($_POST['location_id'],$_POST['value']);													
					if ($scene->id > 0)
					{				
						$results['success'] = 0;
						$results['message'] = 'locations cannot have two scenes with the same value';
						$session->set('results',$results);
						//redirect to edit screen
						Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
					}
				}
				
				//save record to db
				$results = PCPAdmin::getScene()->init($_POST)->save();
				if ($results['success'])
				{
					// update scene id in session
					$session->set('scene_id',$results['id']);
				}
			}
			unset($_POST);
			$session->set('results',$results);
			
			//redirect to edit screen
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
		}
		else
		{
			// We aren't saving anything, go back to the parent
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
		}
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getScene()->init(array('id'=>$_REQUEST['scene_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
	}
	
	function action_assignSceneImage()
	{		
		$session = Session::instance();	
		PCPAdmin::getArgs();			
		if ($session->get('scene_id') && $session->get('image_id'))
		{
			$scene = PCPAdmin::getScene();
			$results = $scene->init(array('image_id'=>$session->get('image_id')))->save();			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
}

?>
