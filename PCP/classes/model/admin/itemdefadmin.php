<?php defined('SYSPATH') or die('No direct script access.');

class Model_Admin_ItemDefAdmin extends Model_PCP_Items
{		
	
	// item definitions define an item by holding images and values for an item type 
	static function getItemDef($args=array())
	{		
		$item = new Model_ItemDef($args);
		return $item->load($args);
	}
	
	static function getItemDefs($args)
	{
		$q = '	SELECT 	id.id
						,id.title
						,id.story_id
				FROM itemdefs id
				INNER JOIN stories s
				ON id.story_id = s.id
				WHERE s.id = :story_id';
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
										->param(':story_id',$args['story_id'])
										->execute()
										->as_array();
		$items = array();
		foreach($tempArray as $a)
		{		
			$items[$a['id']] = self::getItemDef()->init($a);
		}
		return $items;
	}
								 
	static function getData()
	{
		$session = Session::instance('admin');	
		$data = array();
		//Model_Admin_PCPAdmin::clearArgs();
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];	
			$data['add_id'] = 'story_id='.$data['story_id'];		
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
			$data['add_id'] = 'story_id='.$data['story_id'];
		}
		if (isset($_REQUEST['scene_id']))
		{
			$data['scene_id'] = $_REQUEST['scene_id'];	
			$data['add_id'] = 'scene_id='.$data['scene_id'];			
		}
		if (isset($_REQUEST['itemdef_id']))
		{
			$data['id'] = $data['itemdef_id'] = $_REQUEST['itemdef_id'];			
		}
		$data['item_type'] = ITEM_TYPE_DEF;
		$data['user_id'] = $data['creator_user_id'] = Auth::instance()->get_user()->id;
		return $data;
	}
	
}
