<?php defined('SYSPATH') or die('No direct script access.');

/*
 * PCP Admin helper class
 * For accessing all basic admin functionality
 * */

class PCPAdmin
{
	static function getStory($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('story_id')) { $args['id'] =  $session->get('story_id'); }
		return Model_Stories::getStory($args); // get a story object 
	}
	
	static function getStoryInfo($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('story_id')) { $args['id'] =  $session->get('story_id'); }
		return Model_Stories::getStoryInfo($args); // get a story info object 
	}
	
	static function getStories($args=array())
	{	
		//if (!isset($args['user_id'])) { $args['user_id'] = '' }	
		return Model_Stories::getStories($args);		
	}
	
	static function getLocation($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('location_id')) { $args['id'] =  $session->get('location_id'); }
		return Model_locations::getlocation($args); // get a scene location object
	}
	
	static function getLocations($args=array())
	{	
		$args = PCPAdmin::getArgs($args);
		return Model_locations::getlocations($args);		
	}
	
	static function getScene($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('scene_id')) { $args['id'] =  $session->get('scene_id'); }
		return Model_Scenes::getScene($args); // get a scene object
	}
	
	static function getScenes($args=array())
	{		
		$args = PCPAdmin::getArgs($args);
		return Model_Scenes::getScenes($args);
	}

	static function getEvent($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('event_id')) { $args['id'] =  $session->get('event_id'); }				
		return EventsAdmin::getEvent($args); // get a event object and all its locations
	}
	
	static function getEvents($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return EventsAdmin::getEvents($args); // get a story object and all its locations
	}

	static function getUser($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('user_id')) { $args['id'] =  $session->get('user_id'); }
		return UsersAdmin::getUser($args); // get a user object 
	}
	
	static function getUsers($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return UsersAdmin::getUsers($args); 
	}
	
	static function getImage($args=array())
	{
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('image_id')) { $args['id'] =  $session->get('image_id'); }
		return ImagesAdmin::getImage($args);  
	}
	
	static function getImages($args=array())
	{
		$args = PCPAdmin::getArgs($args);
		return ImagesAdmin::getImages($args); 
	}
	
	static function getItemDefs($args=array())
	{			
		$args = PCPAdmin::getArgs($args);
		return ItemAdmin::getItemDefs($args);	
	}
	
	static function getItemDef($args=array())
	{	
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('item_id')) { $args['id'] =  $session->get('item_id'); }	
		return ItemAdmin::getItemDef($args); 		
	}
	
	static function getGridItems($args=array())
	{			
		$args = PCPAdmin::getArgs($args);
		return ItemAdmin::getGridItems($args);	
	}
	
	static function getGridItem($args=array())
	{	
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('grid_item_id')) { $args['id'] =  $session->get('grid_item_id'); }
		//elseif (!isset($args['id']) && $session->get('item_id')) { $args['id'] =  $session->get('item_id'); }
		return ItemAdmin::getGridItem($args); 		
	}
	
	static function getItemstates($args=array())
	{			
		$args = PCPAdmin::getArgs($args);
		return ItemstateAdmin::getItemstates($args);	
	}
	
	static function getItemstate($args=array())
	{	
		$session = Session::instance();
		$args = PCPAdmin::getArgs($args);
		if (!isset($args['id']) && $session->get('itemstate_id')) { $args['id'] =  $session->get('itemstate_id'); }	
		return ItemstateAdmin::getItemstate($args); 		
	}
	
	static function getPlugins($args=array())
	{	
		$pluginAdmin = new pluginadmin();	
		return $pluginAdmin->getPlugins();		
	}
	
	static function getPlugin($args=array())
	{	
		if (!isset($args['plugin']) && $session->get('plugin')) { $args['plugin'] =  $session->get('plugin'); }
		$pluginAdmin = new pluginadmin();	
		return $pluginAdmin->getPlugin($args['plugin']);		
	}
	
	/* get a scene by location ID and value */
	static function getSceneBylocationId($location_id,$scene_value='')
	{
		$args = array('location_id'=>$location_id,'scene_value'=>$scene_value);
		return Model_Scenes::getSceneBylocationId($args);
	}
	
	/* get a itemstate by item ID and value */
	static function getItemStateByItemId($item_id,$itemstate_value='')
	{	
		return Model_Items::getItemStateByItemId(array('item_id'=>$item_id,'itemstate_value'=>$itemstate_value));
	}


	static public function getArgs($args=array())
	{
		$session = Session::instance();		
		if (isset($_REQUEST['story_id']))
		{
			$session->set('story_id',$_REQUEST['story_id']);
			$session->delete('location_id');
			$session->delete('scene_id');			
		}
		if (isset($_REQUEST['location_id']))
		{
			$session->set('location_id',$_REQUEST['location_id']);
		}
		if (isset($_REQUEST['scene_id']))
		{
			$session->set('scene_id',$_REQUEST['scene_id']);
			$session->delete('event_id');
			$session->delete('item_id');			
			$session->delete('grid_item_id');
			$session->delete('cell_id');
			$session->delete('itemstate_id');			
		}
		if (isset($_REQUEST['cell_id']))
		{
			$session->set('cell_id',$_REQUEST['cell_id']);
		}
		if (isset($_REQUEST['event_id']))
		{
			$session->set('event_id',$_REQUEST['event_id']);
		}
		if (isset($_REQUEST['image_id']))
		{
			$session->set('image_id',$_REQUEST['image_id']);
		}
		if (isset($_REQUEST['item_id']))
		{
			$session->set('item_id',$_REQUEST['item_id']);
			$session->delete('image_id');
		}
		if (isset($_REQUEST['itemstate_id']))
		{
			$session->set('itemstate_id',$_REQUEST['itemstate_id']);
		}
		if (isset($_REQUEST['grid_item_id']))
		{
			$session->set('grid_item_id',$_REQUEST['grid_item_id']);
		}
		if (isset($_REQUEST['id']))
		{
			$session->set('id',$_REQUEST['id']);
		}
		if (isset($_REQUEST['user_id']))
		{
			$session->set('user_id',$_REQUEST['user_id']);
		}
		if (isset($_REQUEST['plugin']))
		{
			$session->set('plugin',$_REQUEST['plugin']);
		}
				
		if (!isset($args['story_id']) && $session->get('story_id')) { $args['story_id'] =  $session->get('story_id'); }
		if (!isset($args['location_id']) && $session->get('location_id')) { $args['location_id'] = $session->get('location_id'); }
		if (!isset($args['scene_id']) && $session->get('scene_id')) { $args['scene_id'] =  $session->get('scene_id'); }
		if (!isset($args['cell_id']) &&  $session->get('cell_id')) { $args['cell_id'] =   $session->get('cell_id'); }
		if (!isset($args['event_id']) &&  $session->get('event_id')) { $args['event_id'] =   $session->get('event_id'); }
		if (!isset($args['image_id']) &&  $session->get('image_id')) { $args['image_id'] =   $session->get('image_id'); }
		if (!isset($args['item_id']) &&  $session->get('item_id')) { $args['item_id'] =   $session->get('item_id'); }
		if (!isset($args['itemstate_id']) &&  $session->get('itemstate_id')) { $args['itemstate_id'] =   $session->get('itemstate_id'); }
		if (!isset($args['user_id']) &&  $session->get('user_id')) { $args['user_id'] =   $session->get('user_id'); }
		
		// defaults
		if (!isset($args['include_scenes'])) { $args['include_scenes'] = false; }
		if (!isset($args['include_locations'])) { $args['include_locations'] = false; }
		if (!isset($args['include_events'])) { $args['include_events'] = false; }
		if (!isset($args['include_items'])) { $args['include_items'] = false; }
		if (!isset($args['include_itemstates'])) { $args['include_itemstates'] = false; }
		
		return $args;
	}
	
	static function loadEventDefs()
	{
		EventsAdmin::cacheJSEventDefs(); // cache JS event files
		return EventsAdmin::loadEventDefs(); // get php event classes 
	}
	
	/*
	static function loadJSEventTypes()
	{	
		return EventsAdmin::loadJSEventTypes();
	}
	*/	
}
?>
