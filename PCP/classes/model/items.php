<?php defined('SYSPATH') or die('No direct script access.');
class Model_Items extends Model
{
	static function getGridItems($args=array())
	{						
		// Just get the filenames and put them in an array based on cell id
		$q = '	SELECT 	i.filename
						,i.id as image_id
						,git.cell_id							
				FROM items it
				INNER JOIN images i
				ON it.image_id = i.id
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
		
		$items = $tempArray; // we'll parse this ourselves later on
		return $items;		
	}
}
?>