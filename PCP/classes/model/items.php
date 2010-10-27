<?php defined('SYSPATH') or die('No direct script access.');
class Model_Items extends Model
{
	static function getGridItems($args=array())
	{	
		$items = array();
						
		// Just get the ids and put them in an array based on cell id
		$q = '	SELECT 	git.id
						,git.slug
						,git.cell_id							
				FROM grids_items git
				INNER JOIN scenes sc
				ON git.scene_id = sc.id
				WHERE sc.id = :scene_id
				ORDER BY git.id DESC';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':scene_id',$args['scene']->id)
						->execute()
						->as_array();		
		foreach($tempArray as $item)
		{
			// parse items and build full file paths
			$image = PCP::getitemstate($item);			
			if (isset($image[0]))
			{				
				$items[$item['cell_id']] = $args['story']->getMediaPath().$image[0]['image_id'].'/'.$args['story']->screen_size.'/'.$image[0]['filename'];
			}
		}
		return $items;		
	}
	
	static function getItemStateByItemId($args=array())
	{
		$items = array();
		// Just get the filenames and put them in an array based on cell id
		$q = '	SELECT 	i.id as image_id
						,i.filename
						,its.id
						,its.value
						,its.item_id						
				FROM items_states its
				INNER JOIN images i
				ON its.image_id = i.id
				WHERE 1 = 1
					AND its.value = :value
					AND its.item_id = :item_id
				ORDER BY its.id DESC';				
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':value',$args['itemstate_value'])
						->param(':item_id',$args['item_id'])
						->execute()
						->as_array();
		if (!isset($args['simple_items']) || ($args['simple_items'] == false) )
		{ 
			foreach($tempArray as $a)
			{		
				$a['include_images'] = true;
				$items[$a['id']] = ItemAdmin::getItemState()->init($a);
			}
		}
		else
		{
			// we'll parse this later
			$items = $tempArray;
		}
		return $items;		
	}
	

}
?>