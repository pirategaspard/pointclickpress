<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_scene extends Controller_Template_Admin
{
	
	function action_edit()
	{		
		if(count($_POST) > 0)
		{					
			$this->action_save();
		}	
		$data['story'] = PCPAdmin::getStoryInfo(array('include_containers'=>true,'include_scenes'=>true));	
		$data['story']->setDimensions(800,600);
		$data['container'] = $data['story']->containers[$_REQUEST['container_id']];
		$data['containers'] = $data['story']->containers;	
		$data['scene'] = PCPAdmin::getScene(array('include_actions'=>true));	
		if (strlen($data['scene']->title)==0) $data['scene']->setTitle($data['container']->title);
		$data['actions'] = $data['scene']->actions;
		$data['action'] = PCPAdmin::getAction();		
		$data['event_types'] = Events::getEventTypes();
		
		$data['scene_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'scene','action'=>'save')));		
		$data['actions_form_action'] = Url::site(Route::get('admin')->uri(array('controller'=>'action','action'=>'save')));
		
		$data['scene_grid'] = View::factory('/admin/scene/grid',$data)->render();
		$data['scene_form'] = View::factory('/admin/scene/form',$data)->render();
		$data['add_action'] = View::factory('/admin/action/add',$data)->render();
		$data['action_list'] = View::factory('/admin/action/list',$data)->render();					
		$data['action_form'] = View::factory('/admin/action/form',$data)->render();			
		$data['add_scene'] =  View::factory('/admin/scene/add',$data)->render();
		$data['story_info'] =  View::factory('/admin/story/info',$data)->render();
		$data['container_info'] =  View::factory('/admin/container/info',$data)->render();
		$data['scene_info'] =  View::factory('/admin/scene/info',$data)->render();
		
		$this->template->content = View::factory('/admin/scene/template',$data)->render();
	}
	
	function action_save()
	{
		$results = array();
		if(count($_POST) > 0)
		{
			$results['success'] = 1;
			
			// if we don't have a scene container yet we must create one
			if ((!isset($_POST['container_id'])) ||(strlen($_POST['container_id'])<=0)||($_POST['container_id']<=0))
			{	
				$results = PCPAdmin::getContainer()->init($_POST)->save();
			}				
			if ($results['success'])
			{
				if (isset($_FILES['filename']['name']))
				{
					$_POST['filename'] = $_FILES['filename']['name'];
				}
				
				//save record to db
				$results = PCPAdmin::getScene()->init($_POST)->save();
				if ($results['success'])
				{
					$_POST['id'] = $results['id'];
					$_REQUEST['id'] = $results['id'];
					//save uploaded image
					$results = scenes::uploadScene();
				}
			}
			unset($_POST);
		
			//redirect to edit screen
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id='.$_REQUEST['id']);
		}
		else
		{
			// We aren't saving anything, go back to the parent
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id']);
		}
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getScene()->init(array('id'=>$_REQUEST['scene_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id']);
	}
}

?>
