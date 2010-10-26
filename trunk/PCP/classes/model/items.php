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
			$image = PCP::getItemImage($item);			
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
	

}
?>