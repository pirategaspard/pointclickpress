<?php defined('SYSPATH') or die('No direct script access.');
/* functionality for the front end of PCP */
class Model_PCP_PCP
{
	/* Get the Story Info to use on the story details pages and for rendering scenes */
	static function getStory($args=array())
	{
		if (!isset($args['id']) && isset($_REQUEST['story_id'])) { $args['id'] = $_REQUEST['story_id']; }
		$args = self::getArgs($args);
		return Model_PCP_Stories::getStoryInfo($args); // get a story object and all its locations
	}
	
	/* 
		TODO: remove this.
	  	a cell in a scene has been clicked, 
	  	get the action attached to the cell(s) (if any) 
	 */
	static function getCellAction($scene_id,$cell_id)
	{
		$results = new pcpresult();
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value
				FROM cells c
				INNER JOIN grids_actions g
					ON g.grid_action_id = c.grid_action_id
				INNER JOIN actions e
					ON e.id = g.action_id
				WHERE 	c.id = :cell_id
					AND c.scene_id = :scene_id
				ORDER BY e.id DESC';
		$actions_temp = DB::query(Database::SELECT,$q,TRUE)
								->param(':scene_id',$scene_id)
								->param(':cell_id',$cell_id)
								->execute()
								->as_array();
		
		if (count($actions_temp) > 0)
		{
			foreach($actions_temp as $action_temp)
			{
				$actions[] = actionsAdmin::getGridAction()->init($action_temp); 			
			}
			$results->success = 1;
			$results->data = array('actions'=>$actions);
		}
		return $results;
	}
	
	static function getGridAction($scene_id=0,$cell_id=0)
	{
		$actions = array();		
		//if scene id and cell id are greater than 0
		if (($scene_id > 0) && ($cell_id > 0))
		{				
			$results = PCP::getCellAction($scene_id,$cell_id);	
			if ($results->success)
			{
				$actions = $results->data['actions'];
			}
		}
		return $actions;
	}
	
	static function doAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		return actionsAdmin::doAction($action,$action_value,$type,$action_label,$story_id);
	}

	static function createAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		return actionsAdmin::createAction($action,$action_value,$type,$action_label,$story_id);
	}
	
	static private function getArgs($args=array())
	{
		if (!isset($args['story_id']) && isset($_REQUEST['story_id'])) { $args['story_id'] =  $_REQUEST['story_id']; }
		if (!isset($args['location_id']) && isset($_REQUEST['location_id'])) { $args['location_id'] = $_REQUEST['location_id']; }
		if (!isset($args['scene_id']) && isset($_REQUEST['scene_id'])) { $args['scene_id'] =  $_REQUEST['scene_id']; }
		if (!isset($args['cell_id']) && isset($_REQUEST['cell_id'])) { $args['cell_id'] =  $_REQUEST['cell_id']; }
		if (!isset($args['action_id']) && isset($_REQUEST['action_id'])) { $args['action_id'] =  $_REQUEST['action_id']; }
		
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = false; }
		if (!isset($args['include_locations'])) { $args['include_locations'] = false; }
		if (!isset($args['include_actions'])) { $args['include_actions'] = true; }
		if (!isset($args['include_items'])) { $args['include_items'] = false; } 
		
		return $args;
	}


}
?>
