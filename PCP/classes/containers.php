<?php defined('SYSPATH') or die('No direct script access.');

class Containers
{	
	static function getContainer($args=array())
	{
		// get a single Container object and populate it based on the arguments
		$Container = new Model_Container($args);
		return $Container->load($args);
	}
	
	static function getContainers($args=array())
	{				
		/*
			$args['story'] - story object		   
		*/
		
		$q = '	SELECT c.*
				FROM containers c
				INNER JOIN stories s
				ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['container'])) $q .= 'AND c.id = :container'; //if we have a container id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY c.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['container']))	 $q->param(':container',$args['container']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
								
		$Containers = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_scenes'])) $a['include_scenes'] = $args['include_scenes'];
			if(isset($args['include_actions'])) $a['include_actions'] = $args['include_actions'];
			$Containers[$a['id']] = Containers::getContainer()->init($a);
		}
		return $Containers;		
	}
}
