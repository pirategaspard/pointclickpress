<?php defined('SYSPATH') or die('No direct script access.');

class itemadmin
{									 
	static function getItem($args=array())
	{
		// if we have been passed a type, get that specific type of item, otherwise get a generic item	
		if (isset($args['type']))
		{
			// what kind of event are we getting? 
			switch ($args['type'])
			{	
				case 'Grid':
					unset($args['type']);					
					$item = self::getGridItem($args);					
				break;
				default:
					unset($args['type']);
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
						->param(':scene_id',$args['scene']->id)
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
}