<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_scene extends Controller_Template_Admin
{
	function action_edit()
	{	
		$session = Session::instance('admin');
	
		$data = Model_Admin_ScenesAdmin::GetData();
		$data['scene'] = Model_Admin_ScenesAdmin::getScene(array('id'=>$data['scene_id'],'include_actions'=>false,'include_items'=>true))->init($data);
		$data['story_id'] = (isset($data['story_id']))?$data['story_id']:$data['scene']->story_id;
		$data['story'] = Model_Admin_StoriesAdmin::getStoryInfo(array('id'=>$data['story_id'],'creator_user_id'=>$data['creator_user_id']));
		$data['story']->setDimensions();			
		$data['location'] = Model_Admin_LocationsAdmin::getLocation(array('id'=>$data['scene']->location_id));			
		$data['story_id'] = $data['story']->id;
		$data['location_id'] = $data['location']->id;		
		$data['scene_id'] = $data['scene']->id;	
		$session->set('story_id',$data['story_id']); // This may have been derived from scene obj and other calls may need to use it
		$session->set('location_id',$data['location_id']);
		$session->set('scene_id',$data['scene_id']);						
						
		if (strlen($data['scene']->filename) > 0)
		{
			// items
			if(isset($_REQUEST['griditem_id']))
			{
				$data['items'] = Model_Admin_GriditemAdmin::getGridItemDefaultItemState($_REQUEST['griditem_id']);
			}
			else
			{
				$data['items'] = array();
			}
			$data['grid_item_form'] = Request::factory('/admin/griditem/formgridSimple')->execute()->body();
			$data['grid_items_list'] = Request::factory('/admin/griditem/listgridSimple')->execute()->body();
			
			// actions
			$data['grid_action_form'] = Request::factory('/admin/action/formgridSimple')->execute()->body();
			$data['grid_action_list'] = Request::factory('/admin/action/listgridSimple')->execute()->body();
			
			// grid
			$data['grid'] = View::factory('/admin/scene/grid',$data)->render();
		}
		else
		{
			$data['grid'] = '';
		}
		
		unset($_REQUEST['griditem_id']); // unset this if it exists so that griditem actions will not populate the scene actions list 
		// set the scene title equal to the parent location title if the scene title is empty, else set it to itself
		$data['scene']->setTitle((strlen($data['scene']->title)>0) ? $data['scene']->title : $data['location']->title); //if (strlen($data['scene']->title)==0) $data['scene']->setTitle($data['location']->title);
		// set the story size 
		$data['story']->setDimensions(DEFAULT_SCREEN_WIDTH,DEFAULT_SCREEN_HEIGHT);
		$data['assign_image_link'] = Url::site(Route::get('admin')->uri(array('controller'=>'image','action'=>'list'))).'?story_id='.$data['scene']->story_id.'&location_id='.$data['scene']->location_id.'&scene_id='.$session->get('scene_id');				
		
		/* scene actions */	
		$data['action_list'] = Request::factory('/admin/action/listSimple')->execute()->body();
		
		/* scene */
		$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));						
		$data['scene_form'] = View::factory('/admin/scene/form',$data)->render();
		
		$this->template->scripts[] = 'gridadmin.js'; 
		$this->template->breadcrumb .= View::factory('/admin/story/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/location/info',$data)->render();
		$this->template->breadcrumb .= View::factory('/admin/scene/info',$data)->render();
		$this->template->content = View::factory('/admin/scene/template',$data)->render();
	}
	
	function action_save()
	{
		$session = Session::instance('admin');
		$session->delete('result');
		$data = Model_Admin_ScenesAdmin::GetData();			
		if(count($_POST) > 0)
		{
			// if we don't have a scene location yet we must create one
			if ((!isset($_POST['location_id'])) ||(strlen($_POST['location_id'])<=0)||($_POST['location_id']<=0))
			{					
				$result = Model_Admin_LocationsAdmin::getlocation()->init($data)->save();
				$_POST['location_id'] = $result->data['id'];
			}
			else
			{
				// didn't need to create one, so success! 
				$result = new pcpresult(1);
			}				
			if ($result->success)
			{				
				// check that there is not already a scene in this location with this value
				$scene = Model_Admin_ScenesAdmin::getSceneBylocationId($_POST['location_id'],trim($_POST['value']));																	
				if (($scene->id > 0) && ($scene->id != $_POST['id']))
				{									
					$result = new pcpresult(0,'Locations cannot have two scenes with the same scene value');	
					$session->set('result',$result);
					//redirect to edit screen
					Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$_POST['id']);
				}					
				//save Scene to db
				$result = Model_Admin_ScenesAdmin::getScene()->init($_POST)->save();
				if ($result->success)
				{
					// update scene id in session
					$session->set('scene_id',$result->data['id']);
				}
			}
			$session->set('result',$result);
			
			//redirect to edit screen
			Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$result->data['id']);
		}
		else
		{
			// We aren't saving anything, go back to the parent
			Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
		}
	}
	
	function action_delete()
	{	
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_ScenesAdmin::GetData();
		$result = Model_Admin_ScenesAdmin::getScene()->init($data)->delete();
		$session->set('result',$result);
		//Go back to the parent
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'location','action'=>'edit')));
	}
	
	function action_assignImage()
	{		
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_ScenesAdmin::getData();			
		if (isset($data['scene_id']) && isset($data['image_id']))
		{
			$scene = Model_Admin_ScenesAdmin::getScene(array('id'=>$data['scene_id']));
			$result = $scene->init(array('image_id'=>$data['image_id']))->save();
			$session->set('result',$result);			
		}
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
	
	function action_assignItem()
	{		
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_GridItemAdmin::getData();						
		if (isset($data['scene_id']) && isset($data['itemdef_id']))
		{
			$item = Model_Admin_GridItemAdmin::getGridItem();	
			$result = $item->init($_POST)->save();
			$session->set('result',$result);			
		}
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?tab=2&scene_id='.$_POST['scene_id']);
	}
	function action_DeleteItem()
	{		
		$session = Session::instance('admin');	
		$session->delete('result');
		$data = Model_Admin_GridItemAdmin::getData();					
		if (isset($data['scene_id']) && isset($data['griditem_id']))
		{
			$item = Model_Admin_GridItemAdmin::getGridItem(array('id'=>$data['griditem_id']));
			$result = $item->init($_POST)->delete();
			$session->set('result',$result);			
		}
		Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?scene_id='.$data['scene_id']);
	}
	
	function action_listSimple()
	{
		$this->simple_output();
		$this->action_list();
	}
	
	function action_list()
	{
		$data = Model_Admin_ScenesAdmin::getData();
		$data['scenes'] = Model_Admin_ScenesAdmin::getScenes($data);
		$data['scene_add'] = View::factory('/admin/scene/add',$data)->render();
		$this->template->content = View::factory('/admin/scene/list',$data)->render();	//get location information and load list of locations
	}
}

?>
