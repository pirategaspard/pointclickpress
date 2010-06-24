<?php defined('SYSPATH') or die('No direct script access.');

class Actions
{	
	static function getAction($args=array())
	{
		// get a single Action object and populate it based on the arguments
		$Action = new Model_Action($args);
		return $Action->load($args);
	}
	
	static function getActions($args=array())
	{				
		$q = '	SELECT sa.*
				FROM scene_actions sa
				INNER JOIN scenes sc
					ON sc.id = sa.scene_id
				INNER JOIN scene_containers c
					ON c.id = sc.container_id
				INNER JOIN stories s
					ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['action'])) $q .= 'AND sa.id = :action'; //if we have a action id
		if (isset($args['scene'])) $q .= 'AND sc.id = :scene'; //if we have a scene id
		if (isset($args['container'])) $q .= 'AND c.id = :container'; //if we have a container id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY sa.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['action']))	 $q->param(':action',$args['action']->id);
		if (isset($args['scene']))	 $q->param(':scene',$args['scene']->id);
		if (isset($args['container']))	 $q->param(':container',$args['container']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
								
		$Actions = array();
		foreach($tempArray as $a)
		{
			$Actions[$a['id']] = Actions::getAction()->init($a);
		}
		return $Actions;		
	}
}
