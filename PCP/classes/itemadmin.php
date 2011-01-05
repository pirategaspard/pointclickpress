<?php defined('SYSPATH') or die('No direct script access.');

class itemadmin
{									 
	static function getItem($args=array())
	{
		// if we have been passed a type, get that specific type of item, otherwise get a generic item	
		if (isset($args['item_type']))
		{
			// what kind of event are we getting? 
			switch ($args['item_type'])
			{	
				case 'grid':
					unset($args['item_type']);					
					$item = self::getGridItem($args);					
				break;
				default:
					unset($args['item_type']);
					$item = self::getItemDef($args);
				break;
			}
		}
		else
		{
			$item = self::getItemDef($args);
		}				
		return $item->load($args);
	}
	
	// item definitions define an item by holding images and values for an item type 
	static function getItemDef($args=array())
	{		
		$item = new Model_ItemDef($args);
		return $item->load($args);
	}
	
	// Grid items go on the grid to compose a scene 
	static function getGridItem($args=array())
	{				
		$item = new Model_GridItem($args);
		return $item->load($args);
	}
	
	// Items can have more than one state
	static function getItemState($args=array())
	{		
		$item = new Model_ItemState($args);
		return $item->load($args);
	}
	
	static function getItemDefs($args)
	{
		$q = '	SELECT 	id.id
						,id.title
						,id.story_id
				FROM itemdefs id
				INNER JOIN stories s
				ON id.story_id = s.id
				WHERE s.id = :story_id';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
										->param(':story_id',$args['story_id'])
										->execute()
										->as_array();
		$items = array();
		foreach($tempArray as $a)
		{		
			$items[$a['id']] = ItemAdmin::getItemDef()->init($a);
		}
		return $items;
	}
	
	static function getGridItems($args=array())
	{						 		
		// get all the Items in the db
		$q = '	SELECT 	id.id as itemdef_id	
						,id.title as type						
						,git.id
						,git.cell_id
						,git.scene_id
						,git.title							
				FROM itemdefs id
				INNER JOIN grids_items git
				ON id.id = git.itemdef_id
				INNER JOIN stories s
				ON id.story_id = s.id
				INNER JOIN scenes sc
				ON git.scene_id = sc.id
				WHERE sc.id = :scene_id
				ORDER BY git.id DESC';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':scene_id',$args['scene_id'])
						->execute()
						->as_array();				
		$items = array();
		foreach($tempArray as $a)
		{		
			$a['include_images'] = true;
			$items[$a['cell_id']] = ItemAdmin::getGridItem()->init($a);
		}
		return $items;		
	}
	
	static function getItems($args=array())
	{
		// if we have been passed a type, get that specific type of item, otherwise get a generic item	
		if (!isset($args['item_type'])) {$args['item_type'] = ''; }
			
			// what kind of event are we getting? 
			switch ($args['item_type'])
			{	
				case 'grid':				
					$items = self::getGridItems($args);					
				break;
				case 'def':
					$items = self::getItemDefs($args);
				break;
				default:
					$items = array();
				break;
			}
					
		return $items;
	}
	
	static function getItemType($args=array())
	{
		$type = '';
		if (isset($args['story_id']))
		{
			$type = 'def';
		}
		if (isset($args['scene_id']))
		{
			$type = 'grid';
		}	
		return $type;
	}
	
	static function getData()
	{
		$session = Session::instance();	
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];				
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');
		}
		$data['item_type'] = self::getItemType($data);
		return $data;
	}
}
