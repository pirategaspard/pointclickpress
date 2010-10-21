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
		$data['scene'] = PCPAdmin::getScene(array('include_events'=>true,'include_items'=>true));		
		$data['story'] = PCPAdmin::getStoryInfo(array('id'=>$data['scene']->story_id,'include_locations'=>true,'include_scenes'=>false));			
		$data['location'] = $data['story']->locations[$data['scene']->location_id];
		$data['events'] = $data['scene']->events;						
				
		// set the scene title equal to the parent location title if the scene title is empty, else set it to itself
		$data['scene']->setTitle((strlen($data['scene']->title)>0) ? $data['scene']->title : $data['location']->title); //if (strlen($data['scene']->title)==0) $data['scene']->setTitle($data['location']->title);
		// set the story size 
		$data['story']->setDimensions(DEFAULT_STORY_WIDTH,DEFAULT_STORY_HEIGHT);
		$data['assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?story_id='.$data['scene']->story_id.'&location_id='.$data['scene']->location_id.'&scene_id='.$session->get('scene_id');				
		
		/* scene events */			
		$data['event_add'] = View::factory('/admin/event/add',$data)->render();
		$data['event_list'] = EventsAdmin::getEventsList(array('events'=>$data['scene']->events));				
		
		/* scene */
		$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));						
		$data['scene_form'] = View::factory('/admin/scene/form',$data)->render();
						
		if (strlen($data['scene']->filename) > 0)
		{
			$data['back_url'] = Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene']->id;
		
			// TODO refactor these pieces out of here
		
			/* scene items */
			if (1 == 1)
			{
				$session->delete('image_id');			
			}
			$data['item'] = PCPAdmin::getItem(array('scene_id'=>$data['scene']->id,'type'=>'Grid'));
			$data['item_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'assignItem')));;
			$data['assign_item_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'item','action'=>'list'))).'?scene_id='.$session->get('scene_id');
			$data['item_form'] = View::factory('/admin/item/form_grid',$data)->render(); //inline form
			$data['items'] = $data['scene']->items;
			$data['items_list'] = View::factory('/admin/item/list_grid',$data)->render();
		
			/* grid events */
			$data['story_id'] = $session->get('story_id');
			$data['location_id'] = $session->get('location_id');
			$data['scene_id'] = $session->get('scene_id');
			
			$data['event_types'] = PCPAdmin::loadEventTypes();						
			$data['locations'] = $data['story']->locations;
			$data['event'] = PCPAdmin::getEvent(array('scene_id'=>$data['scene']->id,'type'=>'Grid'));				
			//$data['grid_event_add'] = View::factory('/admin/event/add',$data)->render(); //inline form
			$data['grid_event_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'event','action'=>'save')));									
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
		
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/location/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/scene/info',$data)->render();
		$this->template->top_menu = View::factory('/admin/scene/top_menu',$data)->render();
		$this->template->content = View::factory('/admin/scene/template',$data)->render();
	}
	
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');			
		if(count($_POST) > 0)
		{
			// if we don't have a scene location yet we must create one
			if ((!isset($_POST['location_id'])) ||(strlen($_POST['location_id'])<=0)||($_POST['location_id']<=0))
			{	
				$result = PCPAdmin::getlocation()->init($_POST)->save();
				$_POST['location_id'] = $result->data['id'];
			}
			else
			{
				// didn't need to create one, so success! 
				$result = new pcpresult(1);
			}				
			if ($result->success)
			{				
				//check for duplicates
				if ($session->get('scene_id') == 0)
				{
					// check that there is not already a scene in this location with this value
					$scene = PCPAdmin::getSceneBylocationId($_POST['location_id'],$_POST['value']);													
					if (($scene->id > 0) && ($scene->id != $_POST['id']))
					{			
						$result = new pcpresult(0,'locations cannot have two scenes with the same value');	
						$session->set('result',$result);
						//redirect to edit screen
						Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$_POST['id']);
					}
				}				
				//save Scene to db
				$result = PCPAdmin::getScene()->init($_POST)->save();
				if ($result->success)
				{
					// update scene id in session
					$session->set('scene_id',$result->data['id']);
					$result->message = "Scene Saved";
				}
			}
			$session->set('result',$result);
			
			//redirect to edit screen
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$result->data['id']);
		}
		else
		{
			// We aren't saving anything, go back to the parent
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
		}
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');
		$result = PCPAdmin::getScene()->init(array('id'=>$_REQUEST['scene_id']))->delete();
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
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
	}
	
	function action_assignImage()
	{		
		$session = Session::instance();	
		$session->delete('result');
		PCPAdmin::getArgs();			
		if ($session->get('scene_id') && $session->get('image_id'))
		{
			$scene = PCPAdmin::getScene();
			$result = $scene->init(array('image_id'=>$session->get('image_id')))->save();
			// Create User Message
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
	
	function action_assignItem()
	{		
		$session = Session::instance();	
		$session->delete('result');
		PCPAdmin::getArgs();					
		if ($session->get('scene_id') && $session->get('item_id'))
		{
			$item = PCPAdmin::getItem(array('type'=>'Grid'));			
			$result = $item->init($_POST)->save();
			// Create User Message
			if ($result->success)
			{
				$result->message = "Item Assigned";
			}
			else
			{
				$result->message = "Item NOT Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
	function action_DeleteItem()
	{		
		$session = Session::instance();	
		$session->delete('result');
		PCPAdmin::getArgs();					
		if ($session->get('scene_id') && $session->get('grid_item_id'))
		{
			$item = PCPAdmin::getItem(array('type'=>'Grid'));			
			$result = $item->init($_POST)->delete();
			// Create User Message
			if ($result->success)
			{
				$result->message = "Item Deleted";
			}
			else
			{
				$result->message = "Item NOT Deleted";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
}

?>
