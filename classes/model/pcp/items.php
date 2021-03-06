<?php defined('SYSPATH') or die('No direct script access.');
class Model_PCP_Items extends Model
{

	static function getStoryItems($args)
	{
		$items = array();
		if (isset($args['story_id']))
		{
			// get all the itemdefs that were used as GridItems in the db
			$q = '	SELECT 	DISTINCT id.id as itemdef_id	
							,id.title as itemdef_title						
					FROM grids_items gi
					INNER JOIN scenes sc
					ON gi.scene_id = sc.id
					INNER JOIN itemdefs id
					ON gi.itemdef_id = id.id
					WHERE 1 = 1
					ORDER BY gi.id DESC';
			$tempArray = DB::query(Database::SELECT,$q,TRUE)
							->execute()
							->as_array();
			foreach($tempArray as $a)
			{		
				$items[$a['itemdef_id']] = $a['itemdef_title'];
			}
		}
		return $items;
	}
	
	// Grid items go on the grid to compose a scene 
	static function getStoryGridItems($args=array())
	{						 		
		$items = array();
		if (isset($args['story_id']))
		{
			// get all the itemdefs that were used as GridItems in the db
			$q = '	SELECT 	gi.id
							,gi.title
							,id.id as itemdef_id	
							,id.title as itemdef_title						
					FROM grids_items gi
					INNER JOIN scenes sc
					ON gi.scene_id = sc.id
					INNER JOIN itemdefs id
					ON gi.itemdef_id = id.id
					WHERE 1 = 1
					ORDER BY gi.id DESC';
			$tempArray = DB::query(Database::SELECT,$q,TRUE)
							->execute()
							->as_array();
			foreach($tempArray as $a)
			{		
				$items[$a['id']] = $a['title'];
			}
		}
		return $items;		
	}
	
	// Items can have more than one state
	static function getItemState($args=array())
	{		
		return Model_PCP_Itemstates::getItemState($args);		
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
	
	static function getGridItemItemState($griditem_id=0,$value='')
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
	
	/*
	static function getSceneGridItemInfo($scene_id=0,$item_locations=array())
	{
		$griditemInfo = array();
		if (isset($item_locations[$scene_id]))
		{
			$griditemInfo = $item_locations[$scene_id];
		}
		return $griditemInfo;
	}*/
	
	static function getSceneGriditems($scene_id=0)
	{
		$griditemsInfo = self::getSceneGridItemInfo($scene_id);
		$story_data = Storydata::getStorydata();		
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
				$itemstates[$cell_id] = self::getGridItemItemState($griditemInfo['id'],$itemstate_value);				
			}
		}
		return $itemstates;
	}
	
	static function getGridItemCurrentItemState($griditem_id=0,$value='')
	{
		if (strlen($value) == 0)
		{
			$griditemInfo = self::searchGridItemById($griditem_id);
			$value = $griditemInfo['slug'];
		}		
		$itemstate_value = Storydata::get($value,DEFAULT_ITEMSTATE_VALUE);
		$itemstate = current(self::getGridItemItemState($griditem_id,$itemstate_value));
		return $itemstate;
	}
	
	// gets story item info
	static function getGriditemsInfo()
	{
		return Storydata::get('item_locations',array());		
	}
	
	// sets storyiteminfo
	static function setGriditemsInfo($Iteminfo=array())
	{
		Storydata::set('item_locations',$Iteminfo);
	}
	
	// gets a specific scene's griditem info
	static function getSceneGridItemInfo($scene_id=0)
	{
		$scenegriditems = array();
		$iteminfo = self::getGriditemsInfo();		
		if (isset($iteminfo[$scene_id]))
		{
			$scenegriditems = $iteminfo[$scene_id];
		}
		return $scenegriditems;
	}
	
	// walks array to find griditem_id in storyiteminfo
	static function searchGriditemById($griditem_id=0)
	{
		$foundlocation = array();
		$foundlocation['scene_id'] = 0;
		$foundlocation['cell_id'] = 0;		
		$itemlocations = self::getGriditemsInfo();
		foreach ($itemlocations as $scene_id=>$sceneitemInfo)
		{
			foreach ($sceneitemInfo['griditems'] as $cell_id=>$cell)
			{											
				if ($cell['id'] == $griditem_id)
				{						
					$foundlocation['scene_id'] = $scene_id;
					$foundlocation['cell_id'] = $cell_id;
				}
			}
		}
		return $foundlocation;
	}
	
	// walks array to find griditem slug in storyiteminfo
	static function searchGriditemBySlug($slug='')
	{
		$foundlocation = array();
		$foundlocation['scene_id'] = 0;
		$foundlocation['cell_id'] = 0;		
		$iteminfo = self::getGriditemsInfo();
		foreach ($iteminfo as $scene_id=>$sceneitemInfo)
		{
			foreach ($sceneitemInfo as $cell)
			{
				foreach($cell as $item)
				{										
					if ($item['slug'] == $slug)
					{						
						$foundlocation['scene_id'] = $scene_id;
						$foundlocation['cell_id'] = key($cell);
					}
				}
			}
		}
		return $foundlocation;
	}
	
	static function getGriditemBySceneIdAndCellId($scene_id=0,$cell_id)
	{		
		$item_info = array();
		$sceneItemsInfo = self::getSceneGridItemInfo($scene_id);
		if (isset($sceneItemsInfo['griditems'][$cell_id]))
		{			
			$item_info = $sceneItemsInfo['griditems'][$cell_id]; // get item out of item_locations array
		}
		return $item_info;
	}
	
	static function removeGriditemBySceneIdAndCellId($scene_id=0,$cell_id)
	{		
		$griditemsInfo = self::getGriditemsInfo();
		if (isset($griditemsInfo[$scene_id]['griditems'][$cell_id]))
		{			
			unset($griditemsInfo[$scene_id]['griditems'][$cell_id]); // remove item from array
			self::setGriditemsInfo($griditemsInfo);
		}
	}
	
	/* Use this to update griditems instead of storydata::set(). it keeps itemdata and storydata in sync */
	static function setGriditemValue($slug='',$value='')
	{
		$foundlocation = self::searchGriditemBySlug($slug);						
		if ($foundlocation['scene_id'] != '0')
		{
			$item_info = self::getGriditemBySceneIdAndCellId($foundlocation['scene_id'],$foundlocation['cell_id']);												
			self::setGridItemState($item_info['id'],$value);
			//StoryData::set($slug,$value);
		}	
	}

	// sets a grid item's itemstate_id based on a passed value. 
	static function setGridItemState($griditem_id=0,$value='')
	{
		$foundlocation = self::searchGriditemById($griditem_id);		
		if ($foundlocation['scene_id'] != '0')
		{			
			$itemstate = self::getGridItemItemState($griditem_id,$value);			
			$iteminfo = self::getGriditemsInfo();
			$item = $iteminfo[$foundlocation['scene_id']]['griditems'][$foundlocation['cell_id']];
			$item['itemstate_id'] = $itemstate[$griditem_id]->id;
			$iteminfo[$foundlocation['scene_id']]['griditems'][$foundlocation['cell_id']] = $item;
			self::setGriditemsInfo($iteminfo);
			Storydata::set($item['slug'],$value);			
		}
	}
	
	// moves a grid item to a new scene_id
	static function setGridItemLocation($griditem_id=0,$scene_id=0,$cell_id=1)
	{
		$foundlocation = self::searchGriditemById($griditem_id);
		if ($foundlocation['scene_id'] != '0')
		{						
			$iteminfo = self::getGriditemsInfo();
			$item = $iteminfo[$foundlocation['scene_id']]['griditems'][$foundlocation['cell_id']]; // get item
			$iteminfo[$scene_id]['griditems'][$cell_id] = $item; // move item to new scene
			unset($iteminfo[$foundlocation['scene_id']]['griditems'][$foundlocation['cell_id']]); // remove item from old location
			self::setGriditemsInfo($iteminfo);	
		}
	}
	
	/*
	static function setGriditemBySceneIdAndCellId($scene_id=0,$cell_id=0,$item_info=array())
	{		
		$griditemsInfo = self::getGriditemsInfo();
		if (!isset($griditemsInfo[$scene_id]['griditems'][$cell_id]))
		{			
			$griditemsInfo[$scene_id]['griditems'][$cell_id] = $item_info;
			self::setGriditemsInfo($griditemsInfo);
		}
	}*/
	
	/*
	static function getGriditemInfo($griditem_id=0)
	{
		$foundlocation = searchGriditemInItemInfo($griditem_id);
		if ($foundlocation['story_id'] != 0)
		{
			$iteminfo = self::getGriditemsInfo();
			$item = $iteminfo[$foundlocation['story_id']]['griditems'][$foundlocation['cell_id']]
		}
		return $item;
	}*/
	
	

}
?>
