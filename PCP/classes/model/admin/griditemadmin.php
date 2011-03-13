<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_GridItemAdmin extends Model_PCP_Items
{									 
	static function getItemDef($args=array())
	{		
		$args['item_type'] = ITEM_TYPE_DEF;
		$args['id'] = $args['itemdef_id'];
		return self::getItem($args);
	}
	
	// Grid items go on the grid to compose a scene 
	static function getGridItem($args=array())
	{				
		$args['item_type'] = ITEM_TYPE_GRID;
		return self::getItem($args);
	}
	
	// Grid items go on the grid to compose a scene 
	static function getGridItems($args=array())
	{				
		$args['item_type'] = ITEM_TYPE_GRID;
		return self::getItems($args);
	}
	
	static function getItemType($args=array())
	{
		$type = '';
		if (isset($args['story_id']))
		{
			$type = ITEM_TYPE_DEF;
		}
		if (isset($args['scene_id']))
		{
			$type = ITEM_TYPE_GRID;
		}	
		return $type;
	}
	
	static function getData()
	{
		$session = Session::instance();	
		//Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];	
			$data['add_id'] = 'story_id='.$data['story_id'];		
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
			$data['add_id'] = 'story_id='.$data['story_id'];
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];	
			$data['add_id'] = 'scene_id='.$data['scene_id'];			
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');
			$data['add_id'] = 'scene_id='.$data['scene_id'];	
		}
		if (isset($_REQUEST['itemdef_id']))
		{
			$data['itemdef_id'] = $_REQUEST['itemdef_id'];		
		}
		else
		{
			//$data['itemdef_id'] = 0;
		}
		if (isset($_REQUEST['griditem_id']))
		{
			$data['id'] = $data['griditem_id'] = $_REQUEST['griditem_id'];		
		}
		$data['item_type'] = self::getItemType($data);
		return $data;
	}
}
