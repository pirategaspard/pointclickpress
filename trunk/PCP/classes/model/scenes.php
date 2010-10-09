<?php defined('SYSPATH') or die('No direct script access.');

class Model_Scenes 
{
									 
	static function getScene($args=array())
	{
		// get a Scene_image object and populate it based on the arguments
		$Scene = new Model_Scene($args);		
		return $Scene->load($args);
	}
	
	static function getScenes($args=array())
	{				
		/*
			$args['location'] - story object		   
		*/		
		
		// get all the scenes in the db
		
		$q = '	SELECT sc.*
				FROM scenes sc
				INNER JOIN locations c
				ON c.id = sc.location_id
				INNER JOIN stories s
				ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['scene'])) $q .= 'AND sc.id = :scene'; //if we have a scene id
		if (isset($args['location'])) $q .= 'AND c.id = :location'; //if we have a location id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY sc.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['scene']))	 $q->param(':scene',$args['scene']->id);
		if (isset($args['location']))	 $q->param(':location',$args['location']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
		
		$Scenes = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_events'])) $a['include_events'] = $args['include_events'];			
			$Scenes[$a['id']] = Model_Scenes::getScene()->init($a);
		}
		return $Scenes;		
	}
	
	/* get a scene by location ID and value */
	static function getSceneBylocationId($location_id,$value='')
	{	
		$scene = Model_Scenes::getScene(); // get empty scene object
		$q = '	SELECT 	s.id
						,s.story_id
						,s.location_id
						,s.title
						,s.description
						,s.image_id
						,i.filename
						,s.value
					FROM scenes s
					LEFT OUTER JOIN images i
					ON s.image_id = i.id
					INNER JOIN locations c
						ON s.location_id = c.id 
						AND c.id = :location_id
					WHERE s.value = :value';
		$q_results = DB::query(Database::SELECT,$q,TRUE)
								->param(':location_id',$location_id)
								->param(':value',$value)
								->execute()
								->as_array();
		if (count($q_results) > 0)			
		{
			$args = $q_results[0];
			$args['include_events'] = true;
			$scene->init($args); // populate scene object
		}
		return $scene;
	}
}