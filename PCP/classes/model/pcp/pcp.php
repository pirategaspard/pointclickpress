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
	
	/* get all stories available for the story list page 
	static function getStories($args=array())
	{	
		$args['status'] = 'p'; // only get published stories 
		return Model_Stories::getStories($args);		
	}*/
	
	/* get all the information we need to render a scene 
	static function getScene($args=array())
	{	
		$args['scene_value'] = DEFAULT_SCENE_VALUE;		
		if (isset($args['location_id']))
		{
			$location = Model_locations::getlocation(array('id'=>$args['location_id']));	
			$session = Session::instance();
			$story_data = $session->get('story_data',array());
			
			/*
				Switch for different scenes within location			 
				If a there is a key set in the session story_data array then use that value
				othewise use empty string
						
			if (isset($story_data[$location->slug]))
			{
				$args['scene_value'] = $story_data[$location->slug];
			}
			else
			{
				$args['scene_value'] = DEFAULT_SCENE_VALUE;
			}
		}
		return Model_Scenes::getSceneBylocationId($args); 
	}*/
	/*
	static function getSceneGridItemInfo($scene_id=0,$item_locations=array())
	{
		$griditemInfo = array();
		if (isset($item_locations[$scene_id]))
		{
			$griditemInfo = $item_locations[$scene_id];
		}
		return $griditemInfo;
	}
	
	static function getGriditemsCurrentItemStates($griditemsInfo=array(),$story_data=array())
	{
		$itemstates = array();
		if (isset($griditemsInfo['griditems']))
		{
			foreach($griditemsInfo['griditems'] as $cell_id=>$griditemInfo)
			{
				if (isset($story_data[$griditemInfo['slug']]))
				{
					$itemstate_value = $story_data[$griditemInfo['slug']];
				}
				else
				{
					$itemstate_value = DEFAULT_ITEMSTATE_VALUE;
				} 
				$itemstates[$cell_id] = self::getGridItemCurrentItemState($griditemInfo['id'],$itemstate_value);
				
			}
		}
		return $itemstates;
	}
	
	static function getGridItemCurrentItemState($griditem_id=0,$itemstate_value='')
	{
		return model_items::getGridItemCurrentItemState($griditem_id,$itemstate_value);
	}*/
	
	/*
	static function getSceneItemActions($item_locations)
	{
		$actions = array();
		if (isset($item_locations['griditems']))
		{
			$griditems = $item_locations['griditems'];
			foreach($griditems as $griditem)
			{
				$actions = array_merge(EventsAdmin::getItemDefActions(array('itemdef_id'=>$griditem['itemdef_id'])),$actions);
				$actions = array_merge(EventsAdmin::getItemStateActions(array('itemstate_id'=>$griditem['itemstate_id'])),$actions);
			}
		}
		return $actions;
	}
	
	static function getGridItemActions($griditem_id=0,$scene_id=0)
	{
		$actions = array();
		if (($griditem_id>0)&&($scene_id>0))
		{
			$actions = EventsAdmin::getGridItemActions(array('griditem_id'=>$griditem_id,'scene_id'=>$scene_id));
		}
		return $actions;
	}*/
	
	/* 
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
				$actions[] = EventsAdmin::getGridAction()->init($action_temp); 			
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

	// Event Facade functions 
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
	*/
	/*
	static function doActions($actions)
	{
		return Model_Actions::doActions($actions);		
	}
	*/
	
	static function doAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		return EventsAdmin::doAction($action,$action_value,$type,$action_label,$story_id);
	}

	static function createAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		return EventsAdmin::createAction($action,$action_value,$type,$action_label,$story_id);
	}
	/*
	static function getCurrentlocationID()
	{
		$session = Session::instance();
		$story_data = $session->get('story_data',array());
		if (isset($story_data['location_id']))
		{
			$location_id = $story_data['location_id'];
		}
		else
		{
			$location_id = 0 ;
		}		
		return $location_id;
	}*/
	
	/*
	static function getLocation($location_id = 0)
	{
		$args = PCP::getArgs();
		$args['id'] = $location_id;
		return Model_locations::getlocation($args);
	}*/
	
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
	
	/*
	 * static function getJSActionDefs()
	{	
		return Model_Actions::getJSActionDefs();
	}
	
	
	static function getScreens()
	{
		return Model_Screens::getScreens();
	}
	* */

}
?>
