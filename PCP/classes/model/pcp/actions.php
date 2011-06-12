<?php defined('SYSPATH') or die('No direct script access.');

/*	Frontend actions helper class. */

class Model_PCP_Actions
{	
	// get a single action object and populate it based on the arguments
	static function getAction($args=array())
	{		
		// if we have been passed a type, get that specific type of action, otherwise save a generic action	
		if (isset($args['action_type']))
		{
			// what kind of action are we getting? 
			switch ($args['action_type'])
			{	
				case ACTION_TYPE_ITEMDEF:					
					$action = self::getItemDefAction($args);					
				break;
				case ACTION_TYPE_ITEMSTATE:					
					$action = self::getItemStateAction($args);					
				break;
				case ACTION_TYPE_GRIDITEM:					
					$action = self::getGridItemAction($args);					
				break;
				case ACTION_TYPE_GRID:					
					$action = self::getGridAction($args);					
				break;
				case ACTION_TYPE_SCENE:
					$action = self::getSceneAction($args);
				break;
				case ACTION_TYPE_LOCATION:
					$action = self::getLocationAction($args);
				break;
				case ACTION_TYPE_STORY:
					$action = self::getStoryAction($args);
				break;
				default:
					$action = new Model_Base_Action($args);
				break;
			}
		}
		else
		{
			$action = new Model_Base_PCPAction($args);
		}
		return $action->load($args);
	}
	
	static function getStoryAction($args=array())
	{
		// get a single action object and populate it based on the arguments
		$action = new Model_StoryAction($args);
		return $action->load($args);
	}
	
	static function getLocationAction($args=array())
	{
		// get a single action object and populate it based on the arguments
		$action = new Model_locationAction($args);
		return $action->load($args);
	}
	
	static function getSceneAction($args=array())
	{
		// get a single action object and populate it based on the arguments
		$action = new Model_SceneAction($args);
		return $action->load($args);
	}
	
	static function getGridAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_GridAction($args);
		return $action->load($args);
	}
	
	static function getItemDefAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_ItemdefAction($args);
		return $action->load($args);
	}
	
	static function getItemStateAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_ItemstateAction($args);
		return $action->load($args);
	}
	
	static function getGridItemAction($args=array())
	{		
		// get a single action object and populate it based on the arguments
		$action = new Model_GridItemAction($args);
		return $action->load($args);
	}
	
	static function getActions($args=array())
	{				
		if (!isset($args['action_type'])) {$args['action_type']=ACTION_TYPE_NULL;}	
		
		// what kind of action are we getting? 
		switch ($args['action_type'])
		{	
			case ACTION_TYPE_ITEMSTATE:
				$actions = self::getItemStateActions($args);
			break;
			case ACTION_TYPE_ITEMDEF:
				$actions = self::getItemDefActions($args);
			break;
			case ACTION_TYPE_GRIDITEM:
				$actions = self::getGridItemActions($args);
			break;
			case ACTION_TYPE_SCENE:
				$actions = self::getSceneActions($args);
			break;
			case ACTION_TYPE_LOCATION:
				$actions = self::getLocationActions($args);
			break;
			case ACTION_TYPE_STORY:
				$actions = self::getStoryActions($args);
			break;
			default:
				$actions = array();
			break;
		}

		return $actions;
	}
	
	static function getStoryActions($args=array())
	{			
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.story_id
				FROM actions e
				INNER JOIN stories_actions b
					ON (b.action_id = e.id
					AND b.story_id = :story_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':story_id',$args['story_id'])
					->execute()
					->as_array();			
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getStoryAction()->init($e);
		}
		return $actions;		
	}
	
	static function getLocationActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.location_id
				FROM actions e
				INNER JOIN locations_actions b
					ON (b.action_id = e.id
					AND b.location_id = :location_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':location_id',$args['location_id'])
					->execute()
					->as_array();			
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getLocationAction()->init($e);
		}
		return $actions;		
	}
	
	static function getSceneActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.scene_id
				FROM actions e
				INNER JOIN scenes_actions b
					ON (b.action_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getSceneAction()->init($e);
		}
		return $actions;		
	}
	
	static function getGridActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.grid_action_id,
						b.scene_id
				FROM actions e
				INNER JOIN grids_actions b
					ON (b.action_id = e.id
					AND b.scene_id = :scene_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':scene_id',$args['scene_id'])
					->execute()
					->as_array();			
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getGridAction()->init($e);
		}
		return $actions;		
	}
	
	static function getItemDefActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.itemdef_id
				FROM actions e
				INNER JOIN items_defs_actions b
					ON (e.id = b.action_id
					AND b.itemdef_id = :itemdef_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemdef_id',$args['itemdef_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getItemStateAction()->init($e);
		}
		return $actions;		
	}
	
	static function getItemStateActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.itemstate_id
				FROM actions e
				INNER JOIN items_states_actions b
					ON (e.id = b.action_id
					AND b.itemstate_id = :itemstate_id)
				ORDER BY e.id DESC';
		
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':itemstate_id',$args['itemstate_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getItemstateAction()->init($e);
		}
		return $actions;		
	}
	
	static function getGridItemActions($args=array())
	{				
		$q = '	SELECT 	e.id,
						e.action,
						e.action_label,
						e.action_value,
						b.griditem_id
				FROM actions e
				INNER JOIN grids_items_actions b
					ON (e.id = b.action_id
					AND b.griditem_id = :griditem_id)
				INNER JOIN grids_items gi
					ON (b.griditem_id = gi.id)					
				 ORDER BY e.id DESC';

		$tempArray = DB::query(Database::SELECT,$q,TRUE)
					->param(':griditem_id',$args['griditem_id'])
					->execute()
					->as_array();
		$actions = array();
		foreach($tempArray as $e)
		{
			$actions[$e['id']] = self::getGriditemAction()->init($e);
		}
		return $actions;		
	}
	
	static function getSceneItemActions($scene_id)
	{
		$item_locations = Items::getSceneGriditems($scene_id);
		$actions = array();
		if (isset($item_locations['griditems']))
		{
			$griditems = $item_locations['griditems'];
			foreach($griditems as $griditem)
			{
				$actions = array_merge(self::getItemDefActions(array('itemdef_id'=>$griditem['itemdef_id'])),$actions);
				$actions = array_merge(self::getItemStateActions(array('itemstate_id'=>$griditem['itemstate_id'])),$actions);
			}
		}
		return $actions;
	}

	/*
            a cell in a scene has been clicked,
            get the action attached to the cell(s) (if any)
     */
    static function getCellActions($args=array())
    {
    	$actions = array();
    	if ((isset($args['scene_id']))&&(isset($args['cell_id'])))
		{
			$q = '  SELECT  e.id,
            				e.action,
                            e.action_label,
                            e.action_value
                            FROM cells c
                            INNER JOIN grids_actions g
                                    ON g.grid_action_id = c.grid_action_id
                            INNER JOIN actions e
                                    ON e.id = g.action_id
                            WHERE   c.id = :cell_id
                                    AND c.scene_id = :scene_id
                            ORDER BY e.id DESC';
            	$actions_temp = DB::query(Database::SELECT,$q,TRUE)
                                                            ->param(':scene_id',$args['scene_id'])
                                                            ->param(':cell_id',$args['cell_id'])
                                                            ->execute()
                                                            ->as_array();					
    	        foreach($actions_temp as $action_temp)
            	{
                    	$actions[] = self::getGridAction()->init($action_temp); 
                }                    
			}
            return $actions;
    }


	
/*	static function getGridItemActions($griditem_id=0,$scene_id=0)
	{
		$actions = array();
		if (($griditem_id>0)&&($scene_id>0))
		{
			$actions = self::getGridItemActions(array('griditem_id'=>$griditem_id,'scene_id'=>$scene_id));
		}
		return $actions;
	}
*/
	/* create an action only */
	static function createAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		$args = array(	'action'=>$action
				,'action_value'=>$action_value
				,'type'=>$type
				,'action_label'=>$action_label
				,'story_id'=>$story_id
				);
		$action = self::getAction($args);
		return $action;
	}
		
	// creates an action and then does it, useful when programming custom actions with eval()
	static function makeAction($action='',$action_value='',$type='action',$action_label='',$story_id=0)
	{
		$action = self::createAction($action,$action_value,$type,$action_label,$story_id);
		$action_results = self::doAction($action);
		return $action_results;
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doAction($action)
	{	
		$actions[] = $action;
		return self::doActions($actions);							
	}
	
	/*
		if an action is assigned to the cell this function 
		interprets the cell action(s)
    */
	static function doActions($actions)
	{
		$action_results = array();
		foreach($actions as $action)
		{
			// 'action' is the class name			
			$class_name = $action->action;
			// get the class
			$action_obj = new $class_name; 
			if ($action_obj instanceof Interface_iPCPActionDef)
			{
				Events::announceEvent(strtoupper($class_name).'_EVENT'); // annouce action as an event so other actions/plugins can listen for this.
				// execute action. 
				$action_results = array_merge($action_results,$action_obj->performAction(array('action_value'=>$action->action_value),$class_name));
			}
			else
			{
				throw new Kohana_Exception($class_name . ' is not of type Interface_iPCPActionDef.');
			}
		}
		return $action_results;		
	}
	
	static function getJSActionDefs()
	{	
		return Cache::instance()->get('js_action_defs',Model_Admin_ActionDefsAdmin::cacheJSActionDefs());
	}
}

?>
