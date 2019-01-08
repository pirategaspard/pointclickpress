<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for frontend itemstate data
 * */

class Model_PCP_Itemstates 
{
	
	// Items can have more than one state
	static function getItemState($args=array())
	{		
		$item = new Model_ItemState($args);
		return $item->load($args);
	}
	
	static function getItemstates($args=array())
	{				
		$q = '	SELECT 	i.id AS image_id
						,i.filename
						,its.id
						,its.value
						,its.isdefaultstate
				FROM items_states its
				INNER JOIN itemdefs id 
				ON its.itemdef_id = id.id
				INNER JOIN stories s
				ON id.story_id = s.id
				LEFT OUTER JOIN images i
				ON i.id = its.image_id
				WHERE 1 = 1 ';
				
		if (isset($args['image'])) $q .= ' AND i.id = :image_id'; 
		if (isset($args['itemdef_id'])) $q .= ' AND its.itemdef_id = :itemdef_id';  
		
		$q .= ' ORDER BY i.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);						
		
		if (isset($args['image']))	 $q->param(':image_id',$args['image']->id);
		if (isset($args['itemdef_id'])) $q->param(':itemdef_id',$args['itemdef_id']);
						
		$tempArray = $q->execute()->as_array();		
		
		$itemstates = array();
		foreach($tempArray as $a)
		{
			$itemstates[$a['id']] = self::getItemstate()->init($a);
		}
		return $itemstates;		
	}
	
	static function getItemStateByItemId($args=array())
	{		
		$items = array();
		// Just get the filenames and put them in an array based on cell id
		$q = '	SELECT 	i.id as image_id
						,i.filename
						,its.id
						,its.value
						,its.itemdef_id						
				FROM items_states its
				INNER JOIN images i
				ON its.image_id = i.id
				WHERE 1 = 1
					AND its.value = :value
					AND its.itemdef_id = :itemdef_id
				ORDER BY its.id DESC';				
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':value',$args['itemstate_value'])
						->param(':itemdef_id',$args['itemdef_id'])
						->execute()
						->as_array();
		foreach($tempArray as $a)
		{		
			$a['include_images'] = true;
			$items[$a['id']] = self::getItemState()->init($a);
			//$items[$a['id']]->setPath($args['story']->getMediaPath().$state['image_id'].'/'.$args['story']->screen_size.'/'.$items[$a['id']]->filename);
		}
		return $items;		
	}
	


}
