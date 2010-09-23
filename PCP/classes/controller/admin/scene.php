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

		$session = Session::instance();
						
		$data = EventsAdmin::getUrlParams();
		$data['scene'] = PCPAdmin::getScene(array('include_events'=>true));		
		$data['story'] = PCPAdmin::getStoryInfo(array('id'=>$data['scene']->story_id,'include_containers'=>true,'include_scenes'=>false));
		$data['container'] = $data['story']->containers[$data['scene']->container_id];
		$data['events'] = $data['scene']->events;						
				
		// set the scene title equal to the parent container title if the scene title is empty, else set it to itself
		$data['scene']->setTitle((strlen($data['scene']->title)>0) ? $data['scene']->title : $data['container']->title); //if (strlen($data['scene']->title)==0) $data['scene']->setTitle($data['container']->title);
		// set the story size 
		$data['story']->setDimensions(800,600);
		$data['assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?story_id='.$data['scene']->story_id.'&container_id='.$data['scene']->container_id.'&scene_id='.$session->get('scene_id');
		
		$data['story_info'] =  View::factory('/admin/story/info',$data)->render();
		$data['container_info'] =  View::factory('/admin/container/info',$data)->render();
		$data['scene_info'] =  View::factory('/admin/scene/info',$data)->render();
		$data['scene_add'] =  View::factory('/admin/scene/add',$data)->render();
		
		/* scene events */			
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = EventsAdmin::getEventsList(array('events'=>$data['scene']->events,'url_params'=>$data['url_params']));				
		
		/* scene */
		$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));						
		$data['scene_form'] = View::factory('/admin/scene/form',$data)->render();
						
		if (strlen($data['scene']->filename) > 0)
		{
			/* grid events */
			$data['event_types'] = PCPAdmin::loadEventTypes();						
			$data['containers'] = $data['story']->containers;
			$data['event'] = PCPAdmin::getEvent(array('scene_id'=>$data['scene']->id,'type'=>'Grid'));				
			//$data['grid_event_add'] = View::factory('/admin/event/add',$data)->render(); //inline form
			$data['grid_event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));
			$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene']->id;						
			$data['type'] = 'Grid';
			$data['grid_event_form'] = View::factory('/admin/event/form_grid',$data)->render(); //inline form
			$data['grid_event_list'] = EventsAdmin::getEventsList(array('events'=>$data['scene']->grid_events,'url_params'=>$data['url_params'],'type'=>$data['type']));		
			
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
			
			// if we don't have a scene container yet we must create one
			if ((!isset($_POST['container_id'])) ||(strlen($_POST['container_id'])<=0)||($_POST['container_id']<=0))
			{	
				$results = PCPAdmin::getContainer()->init($_POST)->save();
				$_POST['container_id'] = $results['id'];
			}				
			if ($results['success'])
			{				
				//check for duplicates
				if ($session->get('scene_id') == 0)
				{
					// check that there is not already a scene in this container with this value
					$scene = PCPAdmin::getSceneByContainerId($_POST['container_id'],$_POST['value']);								
					if ($scene->id > 0)
					{				
						$results['success'] = 0;
						$results['message'] = 'Containers cannot have two scenes with the same value';
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
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit')));
		}
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getScene()->init(array('id'=>$_REQUEST['scene_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit')));
	}
}

?>
