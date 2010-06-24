<?php defined('SYSPATH') or die('No direct script access.');

class Cells
{	
	static function getCell($args=array())
	{
		// get a single Cell object and populate it based on the arguments
		$cell = new Model_Cell($args);
		return $cell->load($args);
	}
	
	static function getCells($args=array())
	{				
		$q = '	SELECT 	scl.id,
							scl.action_id,
							sa.scene_id,
							sa.container_id,
							sa.event,
							sa.event_value						
				FROM scene_action_cells scl
				INNER JOIN scene_actions sa
					ON sa.id = scl.action_id
				INNER JOIN scenes sc
					ON sc.id = sa.scene_id
				INNER JOIN scene_containers c
					ON c.id = sc.container_id
				INNER JOIN stories s
					ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['cell'])) $q .= 'AND scl.id = :cell'; //if we have a cell id
		if (isset($args['action'])) $q .= 'AND sa.id = :action'; //if we have a action id
		if (isset($args['scene'])) $q .= 'AND sc.id = :scene'; //if we have a scene id
		if (isset($args['container'])) $q .= 'AND c.id = :container'; //if we have a container id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY scl.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['cell']))	 $q->param(':cell',$args['cell']->id);
		if (isset($args['action']))	 $q->param(':action',$args['action']->id);
		if (isset($args['scene']))	 $q->param(':scene',$args['scene']->id);
		if (isset($args['container']))	 $q->param(':container',$args['container']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
		
		$cells = array();
		foreach($tempArray as $a)
		{
			
			$cells[$a['id']] = Cells::getCell()->init($a);
		}
		return $cells;		
	}
}
