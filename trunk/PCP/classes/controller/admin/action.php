<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_admin_action extends Controller_Template_Admin
{
	
	function action_index()
	{
		//$this->action_list();
	}
	
	function action_list()
	{		

	}
	
	function action_edit()
	{		
		if(count($_POST) > 0)
		{					
			$this->action_save();
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id='.$_REQUEST['scene_id'].'&action_id='.$_REQUEST['action_id']);
	}
	
	function action_save()
	{
		$results = array();
		if(count($_POST) > 0)
		{
			var_dump($_POST);
			
			$_POST['cells'] = explode(',',$_POST['cell_ids']);
			$results = PCPAdmin::getAction()->init($_POST)->save();		
			unset($_POST);
		}
		else
		{
			$results = 'safsdfasfsd';
		}
		//redirect to add a new story
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id='.$_REQUEST['scene_id']);
	}
	
	function action_delete()
	{		
		$results = PCPAdmin::getAction()->init(array('id'=>$_REQUEST['action_id']))->delete();
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'container','action'=>'edit')).'?story_id='.$_REQUEST['story_id'].'&container_id='.$_REQUEST['container_id'].'&scene_id='.$_REQUEST['scene_id']);
	}
}
?>
