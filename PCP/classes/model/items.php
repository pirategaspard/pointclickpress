<?php defined('SYSPATH') or die('No direct script access.');
class Model_Items extends Model
{
	static function getGridItems($args=array())
	{	
		$items = array();
						
		// Just get the filenames and put them in an array based on cell id
		$q = '	SELECT 	it.id
						,it.title
						,git.cell_id							
				FROM items it
				INNER JOIN grids_items git
				ON it.id = git.item_id
				INNER JOIN scenes sc
				ON git.scene_id = sc.id
				WHERE sc.id = :scene_id
				ORDER BY it.id DESC';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':scene_id',$args['scene']->id)
						->execute()
						->as_array();
		foreach($tempArray as $item)
		{
			// parse items and build full file paths
			$a['item_slug'] = Formatting::createSlug($item['title']);
			$image = PCP::getItemImage($a);
			if (isset($image[0]))
			{				
				$items[$item['cell_id']] = $args['story']->getMediaPath().$image[0]['image_id'].'/'.$args['story']->screen_size.'/'.$image[0]['filename'];
			}
		}
		return $items;		
	}
	
	static function getItemImageByItemId($args=array())
	{						
		// Just get the filenames and put them in an array based on cell id
		$q = '	SELECT 	i.id as image_id
						,i.filename						
				FROM items_images ii
				INNER JOIN images i
				ON ii.image_id = i.id
				WHERE ii.value = :value
				ORDER BY ii.id DESC';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':value',$args['itemimage_value'])
						->execute()
						->as_array();
		$items = $tempArray; // we'll parse this ourselves later on
		return $items;		
	}
	
	/*
	static function buildItemImagePaths($args=array())
	{					
		// parse items and build full file path
		$items = array();
		foreach($args['items'] as $item)
		{
			$a['item_slug'] = Formatting::createSlug($item['title']);
			$image = PCP::getItemImage($a);
			if (isset($image[0]))
			{				
				$items[$item['cell_id']] = $args['story'] ->getMediaPath().$image[0]['image_id'].'/'.$args['story']->screen_size.'/'.$image[0]['filename'];
			}
		}
		return $items;
	}
	*/
}
?>