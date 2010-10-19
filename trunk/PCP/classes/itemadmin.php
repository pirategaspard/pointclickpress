<?php defined('SYSPATH') or die('No direct script access.');
// Items go on the grid
class itemadmin
{									 
	static function getItem($args=array())
	{
		// get a Scene Item object and populate it based on the arguments
		$Item = new Model_Item($args);		
		return $Item->load($args);
	}
	
	static function getItems($args=array())
	{				
		/*
			$args['location'] - story object		   
		*/		
		
		// get all the Items in the db
		$q = '	SELECT it.*
				FROM Items it
				INNER JOIN scenes sc
				ON it.scene_id = sc.id
				WHERE 1 = 1 ';
				
		if (isset($args['scene'])) $q .= 'AND sc.id = :scene_id'; //if we have a scene
		
		$q .= ' ORDER BY sc.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['scene']))	 $q->param(':scene_id',$args['scene']->id);
						
		$tempArray = $q->execute()->as_array();
		
		$Items = array();
		foreach($tempArray as $a)
		{		
			$Items[$a['id']] = ItemAdmin::getItem()->init($a);
		}
		return $Items;		
	}
}