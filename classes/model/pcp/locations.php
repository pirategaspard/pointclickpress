<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Contains functions for getting location and locations
 * To Do: move and rename this to locationsAdmin.php?
 * */

class Model_PCP_Locations
{	
	static function getlocation($args=array())
	{
		// get a single location object and populate it based on the arguments
		$location = new Model_location($args);
		return $location->load($args);
	}
	
	static function getlocations($args=array())
	{				
		$q = '	SELECT c.*
				FROM locations c
				INNER JOIN stories s
				ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['location'])) $q .= ' AND c.id = :location'; //if we have a location
		if (isset($args['story_id'])) $q .= ' AND s.id = :story_id'; //if we have a story id
		
		$q .= ' ORDER BY c.title ASC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['location']))	 $q->param(':location',$args['location']->id);
		if (isset($args['story_id']))	 $q->param(':story_id',$args['story_id']);
								
		$tempArray = $q->execute()->as_array();
								
		$locations = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_scenes'])) $a['include_scenes'] = $args['include_scenes'];
			if(isset($args['include_actions'])) $a['include_actions'] = $args['include_actions'];
			$locations[$a['id']] = self::getlocation()->init($a);
		}
		return $locations;		
	}
	
	static function getCurrentlocationID()
	{
		return Storydata::get('location_id',0);		
	}
}
