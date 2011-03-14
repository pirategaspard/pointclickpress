<?php defined('SYSPATH') or die('No direct script access.');

/*
 * PCP Admin helper class
 * For accessing all basic admin functionality
 * */

class Model_Admin_PCPAdmin
{	
	/* get a scene by location ID and value */
	static function getSceneBylocationId($location_id,$scene_value='')
	{
		$args = array('location_id'=>$location_id,'scene_value'=>$scene_value);
		return Model_Scenes::getSceneBylocationId($args);
	}
	
	/* get a itemstate by item ID and value */
	static function getItemStateByItemId($itemdef_id,$itemstate_value='')
	{	
		return Model_ItemStates::getItemStateByItemId(array('itemdef_id'=>$itemdef_id,'itemstate_value'=>$itemstate_value));
	}

	static public function getArgs($args=array())
	{
		$session = Session::instance();		
		if (isset($_REQUEST['story_id']))
		{
			$session->set('story_id',$_REQUEST['story_id']);
			$session->delete('location_id');
			$session->delete('scene_id');
			$session->delete('item_id');
			$session->delete('itemdef_id');
			$session->delete('itemstate_id');			
		}
		if (isset($_REQUEST['location_id']))
		{
			$session->set('location_id',$_REQUEST['location_id']);
		}
		if (isset($_REQUEST['scene_id']))
		{
			$session->set('scene_id',$_REQUEST['scene_id']);
			$session->delete('action_id');
			$session->delete('item_id');			
			$session->delete('griditem_id');
			$session->delete('cell_id');
			$session->delete('itemstate_id');			
		}
		if (isset($_REQUEST['cell_id']))
		{
			$session->set('cell_id',$_REQUEST['cell_id']);
		}
		if (isset($_REQUEST['action_id']))
		{
			$session->set('action_id',$_REQUEST['action_id']);
		}
		if (isset($_REQUEST['image_id']))
		{
			$session->set('image_id',$_REQUEST['image_id']);
		}
		if (isset($_REQUEST['item_id']))
		{
			$session->set('item_id',$_REQUEST['item_id']);
			$session->delete('image_id');
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$session->set('itemstate_id',$_REQUEST['itemstate_id']);
		}
		if (isset($_REQUEST['griditem_id']))
		{
			$session->set('griditem_id',$_REQUEST['griditem_id']);
		}
		if (isset($_REQUEST['id']))
		{
			$session->set('id',$_REQUEST['id']);
		}
		if (isset($_REQUEST['user_id']))
		{
			$session->set('user_id',$_REQUEST['user_id']);
		}
		if (isset($_REQUEST['plugin']))
		{
			$session->set('plugin',$_REQUEST['plugin']);
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$session->set('itemstate_id',$_REQUEST['itemstate_id']);
		}
				
		if (!isset($args['story_id']) && $session->get('story_id')) { $args['story_id'] =  $session->get('story_id'); }
		if (!isset($args['location_id']) && $session->get('location_id')) { $args['location_id'] = $session->get('location_id'); }
		if (!isset($args['scene_id']) && $session->get('scene_id')) { $args['scene_id'] =  $session->get('scene_id'); }
		if (!isset($args['cell_id']) &&  $session->get('cell_id')) { $args['cell_id'] =   $session->get('cell_id'); }
		if (!isset($args['action_id']) &&  $session->get('action_id')) { $args['action_id'] =   $session->get('action_id'); }
		if (!isset($args['image_id']) &&  $session->get('image_id')) { $args['image_id'] =   $session->get('image_id'); }
		if (!isset($args['item_id']) &&  $session->get('item_id')) { $args['item_id'] =   $session->get('item_id'); }
		if (!isset($args['itemstate_id']) &&  $session->get('itemstate_id')) { $args['itemstate_id'] =   $session->get('itemstate_id'); }
		if (!isset($args['user_id']) &&  $session->get('user_id')) { $args['user_id'] =   $session->get('user_id'); }
		
		// defaults
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = false; }
		if (!isset($args['include_locations'])) { $args['include_locations'] = false; }
		if (!isset($args['include_actions'])) { $args['include_actions'] = false; }
		if (!isset($args['include_items'])) { $args['include_items'] = false; }
		if (!isset($args['include_itemstates'])) { $args['include_itemstates'] = false; }
		
		return $args;
	}
	static function clearArgs()
	{
		$session = Session::instance();
		$session->delete('story_id');
		$session->delete('location_id');
		$session->delete('scene_id');
		$session->delete('item_id');
		$session->delete('itemdef_id');
		$session->delete('itemstate_id');
		$session->delete('griditem_id');
		$session->delete('user_id');
		$session->delete('image_id');
		$session->delete('item_id');
		$session->delete('cell_id');
		$session->delete('plugin_id');
	}
}
?>
