<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for frontend scene data
 * */

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
				
		if (isset($args['scene'])) $q .= ' AND sc.id = :scene'; //if we have a scene id
		if (isset($args['location_id'])) $q .= ' AND c.id = :location_id'; //if we have a location id
		if (isset($args['story_id'])) $q .= ' AND s.id = :story_id'; //if we have a story id
		
		$q .= ' ORDER BY sc.id ASC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['scene']))	 $q->param(':scene',$args['scene']->id);
		if (isset($args['location_id']))	 $q->param(':location_id',$args['location_id']);
		if (isset($args['story_id']))	 $q->param(':story_id',$args['story_id']);
								
		$tempArray = $q->execute()->as_array();
		
		$Scenes = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_events'])) $a['include_events'] = $args['include_events'];			
			$Scenes[$a['id']] = Model_Scenes::getScene()->init($a);
		}
		return $Scenes;		
	}
	
	/* get a scene by location ID and value. Called from PCP frontend  */
	static function getSceneBylocationId($args=array())//location_id,$value='')
	{	
		$scene = Model_Scenes::getScene(); // get empty scene object
		if (isset($args['location_id']) && isset($args['scene_value']))
		{		
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
									->param(':location_id',$args['location_id'])
									->param(':value',$args['scene_value'])
									->execute()
									->as_array();										
			if (count($q_results) > 0)			
			{							
				$a = $q_results[0];
				$a['include_events'] = true;
				$a['include_items'] = true;				
				$a['simple_items'] = (isset($args['simple_items']) && $args['simple_items'] == true)?true:false;
				if (isset($args['story']))
				{
					$a['story'] = $args['story'];
				}				
				$scene->init($a); // populate scene object
			}
		}
		return $scene;
	}
}
