<?php defined('SYSPATH') or die('No direct script access.');
class model_inventory extends Model
{

	static function getInventoryItemStateByItemId($args=array())
	{		
		$items = array();
		// Just get the filenames and put them in an array based on cell id
		$q = '	SELECT 	i.id as image_id
						,i.filename
						,its.id
						,its.value
						,its.itemdef_id	
						,its.description					
				FROM items_states its
				INNER JOIN images i
					ON its.image_id = i.id
				WHERE its.id = :id
				ORDER BY its.id DESC';				
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
						->param(':id',$args['id'])
						->execute()
						->as_array();
		foreach($tempArray as $a)
		{		
			$a['include_images'] = true;
			$item = Model_PCP_Items::getItemState()->init($a);
		}
		return $item;		
	}

}