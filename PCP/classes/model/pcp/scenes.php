<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * Contains functions for frontend scene data
 * */

class Model_PCP_Scenes 
{
	static function getScene($args=array())
	{
		// get a Scene_image object and populate it based on the arguments
		$scene = new Model_Scene($args);		
		return $scene->load($args);
	}
	
	static function getScenes($args=array())
	{				
		// get all the scenes in the db
		$q = '	SELECT sc.*,
						i.filename
				FROM scenes sc
				INNER JOIN locations c
				ON c.id = sc.location_id
				INNER JOIN stories s
				ON s.id = c.story_id
				LEFT OUTER JOIN images i
						ON sc.image_id = i.id
				WHERE 1 = 1 ';
				
		if (isset($args['scene_id'])) $q .= ' AND sc.id = :scene_id'; //if we have a scene id
		if (isset($args['location_id'])) $q .= ' AND c.id = :location_id'; //if we have a location id
		if (isset($args['story_id'])) $q .= ' AND s.id = :story_id'; //if we have a story id
		
		$q .= ' ORDER BY sc.title, sc.value ASC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['scene_id']))	 $q->param(':scene_id',$args['scene_id']);
		if (isset($args['location_id']))	 $q->param(':location_id',$args['location_id']);
		if (isset($args['story_id']))	 $q->param(':story_id',$args['story_id']);
								
		$tempArray = $q->execute()->as_array();
		
		$Scenes = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_actions'])) $a['include_actions'] = $args['include_actions'];			
			$Scenes[$a['id']] = self::getScene()->init($a);
		}
		
//		var_dump($Scenes); die();
		return $Scenes;		
	}
	
	/* get a scene by location ID and value. Called from PCP frontend  */
	static function getSceneBylocationId($args=array())//location_id,$value='')
	{	
		$scene = self::getScene(); // get empty scene object
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
				$a['include_actions'] = true;
				$a['include_items'] = true;								
				$scene->init($a); // populate scene object
			}
		}
		return $scene;
	}
	
	static function getCurrentScene($args=array())
	{	
		if (isset($args['location_id']))
		{
			$location = Model_PCP_Locations::getLocation(array('id'=>$args['location_id']));	
			$session = Session::instance();
			/*
				Switch for different scenes within location			 
				If a there is a key set in the session story_data array then use that value
				othewise use empty string
			*/			
			if (StoryData::get($location->slug,0))
			{
				$args['scene_value'] = StoryData::get($location->slug);
			}
			else
			{
				$args['scene_value'] = DEFAULT_SCENE_VALUE;
			}
		}
		return self::getSceneBylocationId($args); 
	}
}
