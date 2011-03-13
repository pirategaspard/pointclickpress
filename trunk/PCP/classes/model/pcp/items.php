<?php defined('SYSPATH') or die('No direct script access.');
class Model_PCP_Items extends Model
{
	static function getItem($args=array())
	{
		// if we have been passed a type, get that specific type of item, otherwise get a generic item	
		if (isset($args['item_type']))
		{
			// what kind of event are we getting? 
			switch ($args['item_type'])
			{	
				case ITEM_TYPE_GRID:
					unset($args['item_type']);					
					$item = self::getGridItem($args);					
				break;
				case ITEM_TYPE_DEF:
					unset($args['item_type']);
					$item = self::getItemDef($args);
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
	
	static function getItems($args=array())
	{
		// if we have been passed a type, get that specific type of item, otherwise get a generic item	
		if (!isset($args['item_type'])) {$args['item_type'] = ITEM_TYPE_NULL; }
			
			// what kind of event are we getting? 
			switch ($args['item_type'])
			{	
				case ITEM_TYPE_GRID:				
					$items = self::getGridItems($args);					
				break;
				case ITEM_TYPE_DEF:
					$items = self::getItemDefs($args);
				break;
				default:
					$items = array();
				break;
			}
					
		return $items;
	}
	
	// item definitions define an item by holding images and values for an item type 
	static function getItemDef($args=array())
	{		
		$item = new Model_ItemDef($args);
		return $item->load($args);
	}
	
	// Items can have more than one state
	static function getItemState($args=array())
	{		
		$item = new Model_ItemState($args);
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
			$items[$a['id']] = self::getItemDef()->init($a);
		}
		return $items;
	}
	
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
	
	static function getStoryItemInfo($args)
	{
		$q = '	SELECT 	gi.id
						,gi.slug
						,gi.scene_id
						,gi.cell_id
						,gi.itemdef_id
						,its.value
						,its.id as itemstate_id
				FROM grids_items gi
				INNER JOIN itemdefs id
				ON gi.itemdef_id = id.id
				INNER JOIN items_states its
				ON id.id = its.itemdef_id
				AND its.isdefaultstate = 1
				INNER JOIN stories s
				ON id.story_id = s.id
				WHERE s.id = :story_id';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
										->param(':story_id',$args['story_id'])
										->execute()
										->as_array();
		$item_info = array();
		$item_data = array();
		$item_locations = array();
		foreach($tempArray as $a)
		{		
			// we set this into story_data to control the value of the griditems itemstates
			$item_data[$a['slug']] = $a['value'];
			// we need this to display the item on the correct cell in the grid, holds griditem data for that cell location
			// TODO: itemstate id is saved here. May need to refactor this out, or remember to update this data when the item value changes in story_data?
			$item_locations[$a['scene_id']]['griditems'][$a['cell_id']] = array('id'=>$a['id'],'slug'=>$a['slug'],'itemdef_id'=>$a['itemdef_id'],'itemstate_id'=>$a['itemstate_id']);

		}
		$item_info['item_data'] = $item_data;
		$item_info['item_locations'] = $item_locations;
		return $item_info;
	}
	
	static function getGridItemCurrentItemState($griditem_id=0,$value='')
	{
		$q = '	SELECT 	i.id AS image_id
						,i.filename
						,its.id
						,its.value
						,gi.id AS griditem_id
				FROM grids_items gi
				INNER JOIN itemdefs id
				ON gi.itemdef_id = id.id
				INNER JOIN items_states its
				ON id.id = its.itemdef_id
				AND its.value = :value
				LEFT OUTER JOIN images i
				ON its.image_id = i.id
				WHERE gi.id = :griditem_id';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
								->param(':griditem_id',$griditem_id)
								->param(':value',$value)
								->execute()
								->as_array();
		$itemstates = array();
		foreach($tempArray as $a)
		{
			$itemstates[$a['griditem_id']] = self::getItemstate()->init($a);
		}
		return $itemstates; 
	}
	
	static function getSceneGridItemInfo($scene_id=0,$item_locations=array())
	{
		$griditemInfo = array();
		if (isset($item_locations[$scene_id]))
		{
			$griditemInfo = $item_locations[$scene_id];
		}
		return $griditemInfo;
	}
	
	static function getGriditemsCurrentItemStates($griditemsInfo=array(),$story_data=array())
	{
		$itemstates = array();
		if (isset($griditemsInfo['griditems']))
		{
			foreach($griditemsInfo['griditems'] as $cell_id=>$griditemInfo)
			{
				if (isset($story_data[$griditemInfo['slug']]))
				{
					$itemstate_value = $story_data[$griditemInfo['slug']];
				}
				else
				{
					$itemstate_value = DEFAULT_ITEMSTATE_VALUE;
				} 
				$itemstates[$cell_id] = self::getGridItemCurrentItemState($griditemInfo['id'],$itemstate_value);
				
			}
		}
		return $itemstates;
	}

}
?>
