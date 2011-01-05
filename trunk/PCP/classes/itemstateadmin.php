<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * backend Itemstates helper file.
 * Contains functions for getting Itemstate and Itemstates and managing Itemstates in the PCP admin
 * */

class ItemstateAdmin
{

	static function getItemstate($args=array())
	{
		// get a single object and populate it based on the arguments
		$obj = new Model_itemstate($args);
		$obj->load($args);
		return $obj;		
	}

	static function getItemstates($args=array())
	{				
		$q = '	SELECT 	i.id AS image_id
						,i.filename
						,its.id
						,its.value
				FROM items_states its
				INNER JOIN itemdefs id 
				ON its.item_id = id.id
				INNER JOIN stories s
				ON id.story_id = s.id
				LEFT OUTER JOIN images i
				ON i.id = its.image_id
				WHERE 1 = 1 ';
				
		if (isset($args['image'])) $q .= ' AND i.id = :image_id'; 
		if (isset($args['item_id'])) $q .= ' AND its.item_id = :item_id';
		if (isset($args['ItemDef_id'])) $q .= ' AND its.item_id = :item_id';  
		
		$q .= ' ORDER BY i.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);						
		
		if (isset($args['image']))	 $q->param(':image_id',$args['image']->id);
		if (isset($args['item_id']))	 $q->param(':item_id',$args['item_id']);
		if (isset($args['ItemDef_id'])) $q->param(':item_id',$args['ItemDef_id']);
						
		$tempArray = $q->execute()->as_array();		
		
		$itemstates = array();
		foreach($tempArray as $a)
		{
			$itemstates[$a['id']] = self::getItemstate()->init($a);
		}
		return $itemstates;		
	}

	static function getData()
	{
		$session = Session::instance();	
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];			
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['Itemstate_id']))
		{
			$data['Itemstate_id'] = $_REQUEST['Itemstate_id'];	
		}
		else if ($session->get('Itemstate_id'))
		{
			$data['Itemstate_id'] = $session->get('Itemstate_id');
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];				
		}
		else if ($session->get('scene_id'))
		{
			$data['scene_id'] = $session->get('scene_id');
		}
		if (isset($_REQUEST['item_id']))
		{
			$data['item_id'] = $_REQUEST['item_id'];				
		}
		else if ($session->get('item_id'))
		{
			$data['item_id'] = $session->get('item_id');
		}
		return $data;
	}

}
?>
