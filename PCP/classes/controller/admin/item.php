<?php defined('SYSPATH') or die('No direct script access.');
Class Controller_admin_item extends Controller_Template_Admin
{	
	/*
		save the info from the Item form 
	*/
	function action_save()
	{
		$session = Session::instance();
		$session->delete('result');		
		if(count($_POST) > 0)
		{
			$result = PCPAdmin::getItem()->init($_POST)->save();
			$session->set('Item_id',$result->data['id']);			
		}
		else
		{
			$result = new pcpresult(0,'unable to save Item data');
		}
		if ($result->success)
		{
			$result->message = "Item Saved";
		}
		$session->set('result',$result);
		//redirect to edit the Item just saved
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}
	
	function action_delete()
	{	
		$session = Session::instance();	
		$session->delete('result');
		var_dump('HEY'); die();	
		$result = PCPAdmin::getItem()->init(array('id'=>$_REQUEST['item_id']))->delete();
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
		Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'scene','action'=>'edit')));
	}

}

?>