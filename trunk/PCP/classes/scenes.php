<?php defined('SYSPATH') or die('No direct script access.');

class Scenes 
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
			$args['container'] - story object		   
		*/		
		
		// get all the scenes in the db
		
		$q = '	SELECT sc.*
				FROM scenes sc
				INNER JOIN containers c
				ON c.id = sc.container_id
				INNER JOIN stories s
				ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['scene'])) $q .= 'AND sc.id = :scene'; //if we have a scene id
		if (isset($args['container'])) $q .= 'AND c.id = :container'; //if we have a container id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY sc.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['scene']))	 $q->param(':scene',$args['scene']->id);
		if (isset($args['container']))	 $q->param(':container',$args['container']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
		
		$Scenes = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_actions'])) $a['include_actions'] = $args['include_actions'];			
			$Scenes[$a['id']] = Scenes::getScene()->init($a);
		}
		return $Scenes;		
	}
	
	/* get a scene by container ID and value */
	static function getSceneByContainerId($container_id,$value='')
	{	
		$scene = Scenes::getScene(); // get empty scene object
		$q = '	SELECT 	s.id
						,s.story_id
						,s.container_id
						,s.title
						,s.description
						,s.image_id
						,i.filename
						,s.value
					FROM scenes s
					INNER JOIN images i
					ON s.image_id = i.id
					INNER JOIN containers c
						ON s.container_id = c.id 
						AND c.id = :container_id
					WHERE value = :value';
		$results = DB::query(Database::SELECT,$q,TRUE)
								->param(':container_id',$container_id)
								->param(':value',$value)
								->execute()
								->as_array();
		if (count($results) > 0)			
		{
			$args = $results[0];
			$args['include_events'] = true;
			$scene->init($args); // populate scene object
		}
		return $scene;
	}
}
