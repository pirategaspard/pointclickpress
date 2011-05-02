<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Actions helper file.
 * Contains functions for getting action and actions and managing actions in the PCP admin
 * */

class Model_Admin_ActionsAdmin extends Model_PCP_Actions
{		
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
	
	static function getActionsList($args=array())
	{
		if (!isset($args['action_type'])) {$args['action_type']=ACTION_TYPE_NULL;}		
		switch ($args['action_type'])
		{
			case ACTION_TYPE_GRID:				
				$view = View::factory('/admin/action/list_grid',$args)->render();
			break;
			default:
				$view = View::factory('/admin/action/list',$args)->render();
			break;
		}
		return $view;
	}
	
	static function getActionType($args=array())
	{
		$type = '';	
		$session = Session::instance('admin');	
		if (isset($args['story_id']))
		{
			$type = ACTION_TYPE_STORY;
		}
		if (isset($args['location_id']))
		{
			$type = ACTION_TYPE_LOCATION;
		}
		if (isset($args['scene_id']))
		{
			$type = ACTION_TYPE_SCENE;
		}
		if (isset($args['cell_ids']))
		{
			$type = ACTION_TYPE_GRID;
		}
		if (isset($args['itemdef_id']))
		{
			$type = ACTION_TYPE_ITEMDEF;
		}
		if (isset($args['itemstate_id']))
		{
			$type = ACTION_TYPE_ITEMSTATE;
		}
		if (isset($args['griditem_id']))
		{
			$type = ACTION_TYPE_GRIDITEM;
		}	
		return $type;
	} 
	
	static function getData()
	{
		$session = Session::instance('admin');
		//Model_Admin_PCPAdmin::clearArgs();	
		$data = array();
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['location_id']))
		{
			$data['location_id'] = $_REQUEST['location_id'];	
		}
		else if ($session->get('location_id'))
		{
			$data['location_id'] = $session->get('location_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];				
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');	
		}
		if (isset($_REQUEST['itemdef_id']))
		{
			$data['itemdef_id'] = $_REQUEST['itemdef_id'];				
		}
		else if ($session->get('itemdef_id'))
		{
			$data['itemdef_id'] = $session->get('itemdef_id');
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$data['itemstate_id'] = $_REQUEST['itemstate_id'];				
		}
		else if ($session->get('itemstate_id'))
		{
			$data['itemstate_id'] = $session->get('itemstate_id');
		}
		if (isset($_REQUEST['griditem_id']))
		{
			$data['griditem_id'] = $_REQUEST['griditem_id'];				
		}
		else if ($session->get('griditem_id'))
		{
			$data['griditem_id'] = $session->get('griditem_id');
		}
		if (isset($_REQUEST['action_id']))
		{
			$data['id'] = $data['action_id'] = $_REQUEST['action_id'];
		}
		else
		{
			$data['id'] = $data['action_id'] = 0; 
		}
		$data['user_id'] = $data['creator_user_id'] = model_admin_usersadmin::getUserId();
		$data['action_type'] = self::getActionType($data);
		switch ($data['action_type'])
		{	
			case ACTION_TYPE_STORY:
				$data['add_id'] = 'story_id='.$data['story_id'];
			break;
			case ACTION_TYPE_LOCATION:
				$data['add_id'] = 'location_id='.$data['location_id'];
			break;
			case ACTION_TYPE_SCENE:
				$data['add_id'] = 'scene_id='.$data['scene_id'];
			break;
			case ACTION_TYPE_ITEMDEF:
				$data['add_id'] = 'itemdef_id='.$data['itemdef_id'];
			break;
			case ACTION_TYPE_ITEMSTATE:
				$data['add_id'] = 'itemstate_id='.$data['itemstate_id'];
			break;
			case ACTION_TYPE_GRIDITEM:
				$data['add_id'] = 'griditem_id='.$data['griditem_id'];
			break;
			default:
				$data['add_id'] = '';
			break;
		}
		return $data;
	}
}

