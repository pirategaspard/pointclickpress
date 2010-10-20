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
					$item = ItemAdmin::getGridItem($args);					
				break;
				default:
					$item = new Model_Item($args);
				break;
			}
		}
		else
		{
			$item = new Model_Item($args);
		}				
		return $item->load($args);
	}
	
	// Grid items go on the grid to compose a scene 
	static function getGridItem($args=array())
	{		
		$item = new Model_GridItem($args);
		return $item->load($args);
	}
	
	static function getItems($args)
	{
		$q = '	SELECT 	it.id
						,it.label
						,it.story_id
						,it.image_id
						,i.filename
				FROM items it
				INNER JOIN images i
				ON it.image_id = i.id
				INNER JOIN stories s
				ON it.story_id = s.id
				WHERE s.id = :story_id';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
										->param(':story_id',$args['story_id'])
										->execute()
										->as_array();
		$items = array();
		foreach($tempArray as $a)
		{		
			$items[$a['id']] = ItemAdmin::getItem()->init($a);
		}
		return $items;
	}
	
	static function getGridItems($args=array())
	{						
		// get all the Items in the db
		$q = '	SELECT 	it.id	
						,it.label						
						,it.image_id
						,it.story_id
						,i.filename
						,git.cell_id
						,git.scene_id							
				FROM items it
				INNER JOIN images i
				ON it.image_id = i.id
				INNER JOIN grids_items git
				ON it.id = git.item_id
				INNER JOIN stories s
				ON it.story_id = s.id
				INNER JOIN scenes sc
				ON git.scene_id = sc.id
				WHERE sc.id = :scene_id
				ORDER BY it.id DESC';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':scene_id',$args['scene']->id)
						->execute()
						->as_array();
		
		$items = array();
		foreach($tempArray as $a)
		{		
			$items[$a['cell_id']] = ItemAdmin::getGridItem()->init($a);
		}
		return $items;		
	}
}