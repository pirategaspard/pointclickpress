<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_GridItemAdmin extends Model_PCP_Items
{									 
	// Grid items go on the grid to compose a scene 
	static function getGridItem($args=array())
	{				
		$item = new Model_GridItem($args);
		return $item->load($args);
	}
	
	// Grid items go on the grid to compose a scene 
	static function getGridItems($args=array())
	{						 		
		$items = array();
		if ((isset($args['itemdef_id']))||(isset($args['scene_id'])))
		{
			// get all the Items in the db
			$q = '	SELECT 	id.id as itemdef_id	
							,id.title as itemdef_title						
							,gi.id
							,gi.cell_id
							,gi.scene_id
							,gi.title							
					FROM grids_items gi
					INNER JOIN scenes sc
					ON gi.scene_id = sc.id
					LEFT OUTER JOIN itemdefs id
					ON gi.itemdef_id = id.id
					WHERE 1 = 1';
			if (isset($args['itemdef_id']))
			{	
					$q .= ' AND id.id = :itemdef_id';
			}
			if (isset($args['scene_id']))
			{
					$q .= ' AND sc.id = :scene_id';
			}
					$q .= ' ORDER BY gi.id DESC';
			$query = DB::query(Database::SELECT,$q,TRUE);
			
			if (isset($args['itemdef_id']))
			{				
				$query->param(':itemdef_id',$args['itemdef_id']);
			}
			if (isset($args['scene_id']))
			{
				$query->param(':scene_id',$args['scene_id']);
			}
			$tempArray = $query->execute()->as_array();	
						
			foreach($tempArray as $a)
			{		
				$items[$a['cell_id']] = self::getGridItem()->init($a);
			}
		}
		return $items;		
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
		$session = Session::instance('admin');	
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
