<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_CellsAdmin extends Model
{	
	static function getCell($args=array())
	{
		// get a single Cell object and populate it based on the arguments
		$cell = new Model_Admin_Cell($args);
		return $cell->load($args);
	}
	
	static function getCells($args=array())
	{		
		$q = '	SELECT 	cl.id						
				FROM cells cl
				INNER JOIN grids_events g
					ON g.grid_event_id = cl.grid_event_id
				INNER JOIN events e
					ON e.id = g.event_id
				INNER JOIN scenes sc
					ON sc.id = g.scene_id
				INNER JOIN locations c
					ON c.id = sc.location_id
				INNER JOIN stories s
					ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['cell'])) $q .= ' AND cl.id = :cell '; //if we have a cell id
		if (isset($args['event'])) $q .= ' AND e.id = :event '; //if we have a action id
		if (isset($args['scene'])) $q .= ' AND sc.id = :scene '; //if we have a scene id
		if (isset($args['location'])) $q .= ' AND c.id = :location '; //if we have a location id
		if (isset($args['story'])) $q .= ' AND s.id = :story '; //if we have a story id
		
		$q .= ' ORDER BY cl.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['cell']))	 	$q->param(':cell',$args['cell']->id);
		if (isset($args['event']))		$q->param(':event',$args['event']->id);
		if (isset($args['scene']))		$q->param(':scene',$args['scene']->id);
		if (isset($args['location']))	$q->param(':location',$args['location']->id);
		if (isset($args['story']))		$q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
		
		$cells = array();
		foreach($tempArray as $a)
		{
			
			$cells[$a['id']] = self::getCell()->init($a);
		}
		return $cells;		
	}
}
