<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_item extends Controller_Template_Admin
{	
	function action_assignImage()
	{		
		$session = Session::instance();	
		$session->delete('result');
		PCPAdmin::getArgs();			
		if ($session->get('scene_id') && $session->get('cell_id') && $session->get('image_id'))
		{
			$item = PCPAdmin::getItem();
			$result = $item->init(array('image_id'=>$session->get('image_id')))->save();
			if ($result->success)
			{
				$result->message = "Image Assigned";
			}
			$session->set('result',$result);			
		}
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');	
		$result = PCPAdmin::getStory()->init(array('id'=>$_REQUEST['item_id']))->delete();
		// Create User Message
		if ($result->success)
		{
			$result->message = "Item Deleted";
		}
		elseif($result->success == 0)
		{
			$result->message = "Unable to Delete Item";
		}
		$session->set('result',$result);	
		//Go back to the parent
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'list')));
	}

}

?>