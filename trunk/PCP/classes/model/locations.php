<?php defined('SYSPATH') or die('No direct script access.');

class Model_locations
{	
	static function getlocation($args=array())
	{
		// get a single location object and populate it based on the arguments
		$location = new Model_location($args);
		return $location->load($args);
	}
	
	static function getlocations($args=array())
	{				
		/*
			$args['story'] - story object		   
		*/
		
		$q = '	SELECT c.*
				FROM locations c
				INNER JOIN stories s
				ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['location'])) $q .= 'AND c.id = :location'; //if we have a location id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY c.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['location']))	 $q->param(':location',$args['location']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
								
		$locations = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_scenes'])) $a['include_scenes'] = $args['include_scenes'];
			if(isset($args['include_events'])) $a['include_events'] = $args['include_events'];
			$locations[$a['id']] = Model_locations::getlocation()->init($a);
		}
		return $locations;		
	}
}
