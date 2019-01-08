<?php 
/*
	Basic Inventory plugin for PointClickPress
 */
define('INVENTORY_DROP_SELECTED_ITEM','INVENTORY_DROP_SELECTED_ITEM');
define('INVENTORY_SET_SELECTED_ITEM','INVENTORY_SET_SELECTED_ITEM');
define('INVENTORY_DISPLAY','INVENTORY_DISPLAY');
class plugins_inventory extends Model_Base_PCPPlugin
{	
	protected $label = 'Inventory'; // This is the label for this plugin
	protected $description = 'Basic inventory plugin for PCP'; // This is the description of this plugin
	protected $events = array(POST_START_STORY,CSS,ADMIN_JS,JS,POST_SCENE_BOTTOM_MENU,DISPLAY_POST_GRID_SELECT,INVENTORY_DISPLAY,INVENTORY_SET_SELECTED_ITEM,INVENTORY_DROP_SELECTED_ITEM); // This is an array of events to call this plugin from
	
	public function execute($event_name='')
	{
		switch($event_name)
		{
			case POST_START_STORY:
			{
				// init current item in session
				Storydata::set('current_item','');
				break;
			}
			case CSS:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','css'));
				break;
			}
			case JS:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','js'));
				break;
			}	
			case ADMIN_JS:
			{		
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','admin.js'));
				break;
			}
			case POST_SCENE_BOTTOM_MENU:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','link'));
				break;
			}
			case DISPLAY_POST_GRID_SELECT:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','gridselect'));
				break;
			}	
			case INVENTORY_DISPLAY:
			{
				include(Kohana::find_file('plugins'.DIRECTORY_SEPARATOR.'inventory','display'));
				break;
			}
			case INVENTORY_SET_SELECTED_ITEM:
			{
				self::setSelectedItem();
				break;
			}
			case INVENTORY_DROP_SELECTED_ITEM:
			{
				self::dropSelectedItem();
				break;
			}
		}	
	}
	
	static public function getCurrentItem()
	{
		return Storydata::get('current_item',0);
	}
	
	static public function setCurrentItem($griditem_id=0)
	{
		$curr_item_id = self::getCurrentItem();
		if ($curr_item_id == $griditem_id)
		{
			// if we click on the item that is already current, unselect
			$griditem_id = 0;
		}
		$story_data = Storydata::set('current_item',$griditem_id);			
	}
	
	static public function setSelectedItem()
	{
		if (isset($_REQUEST['i']))
		{
			self::setCurrentItem($_REQUEST['i']);		
			if (!Request::Current()->is_ajax())
			{    		
				// no javascript - refresh the page no matter what happened. 
				Request::Current()->redirect(Route::get('default')->uri(array('action'=>'scene')));
			}
		}
	}
	
	static public function dropSelectedItem()
	{
		$griditem_id = self::getCurrentItem();
		$story_data = Storydata::getStorydata();
		$s = Session::instance();
		$cell_id = ($s->get('story')->grid_total());
		$empty = false;
		while(!$empty)
		{
			$cell_id = $cell_id-1;
			$item = Items::getGriditemBySceneIdAndCellId($story_data['scene_id'],$cell_id);
			if (count($item) == 0)
			{
				$empty = true;				
			}
		}
		// put current item into the scene in the last cell
		Items::setGridItemLocation($griditem_id,$story_data['scene_id'],$cell_id); 
		self::setCurrentItem(0); 
		if (Request::Current()->is_ajax())
		{   
			// trigger item refresh
			$act = new action_refreshitems();
			echo json_encode($act->performAction());
		}
		else
		{ 		
			// no javascript - refresh the page no matter what happened. 
			Request::Current()->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}
	}
	
	static public function getInventory()
	{
		$inventory_items = array();
		$item_locations = Items::getGriditemsInfo();
		if(isset($item_locations['inventory']))
		{
			$inventory_items = $item_locations['inventory'];
		}
		return $inventory_items;
	}
}
