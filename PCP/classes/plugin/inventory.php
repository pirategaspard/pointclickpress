<?php 
/*
	Basic Inventory plugin for PointClickPress
 */
define('INVENTORY_DROPCURRENTITEM','INVENTORY_DROPCURRENTITEM');
define('INVENTORY_SETCURRENTITEM','INVENTORY_SETCURRENTITEM');
define('INVENTORY_DISPLAY','INVENTORY_DISPLAY');
class plugin_inventory extends Model_Base_PCPPlugin
{	
	protected $label = 'Inventory'; // This is the label for this plugin
	protected $description = 'Basic inventory plugin for PCP'; // This is the description of this plugin
	protected $events = array(POST_START_STORY,CSS,ADMIN_JS,JS,DISPLAY_POST_SCENE,DISPLAY_POST_GRID_SELECT,INVENTORY_DISPLAY,INVENTORY_SETCURRENTITEM,INVENTORY_DROPCURRENTITEM); // This is an array of events to call this plugin from
	
	public function execute($event_name='')
	{
		switch($event_name)
		{
			case POST_START_STORY:
			{
				// init current item in session
				Storydata::set('current_item','');
			}
			case CSS:
			{
				include('inventory/css.php');
				break;
			}
			case JS:
			{
				include('inventory/js.php');
				break;
			}	
			case ADMIN_JS:
			{
				include('inventory/admin.js.php');
				break;
			}
			case DISPLAY_POST_SCENE:
			{
				include('inventory/link.php');
				break;
			}
			case DISPLAY_POST_GRID_SELECT:
			{
				include('inventory/gridselect.php');
				break;
			}	
			case INVENTORY_DISPLAY:
			{
				self::display();
				break;
			}
			case INVENTORY_SETCURRENTITEM:
			{
				self::setCurrentItem();
				break;
			}
			case INVENTORY_DROPCURRENTITEM:
			{
				self::dropCurrentItem();
				break;
			}
		}	
	}
	
	static public function display()
	{
		include('inventory/display.php');
	}
	
	static public function getCurrentItem()
	{
		return Storydata::get('current_item','');
	}
	
	static public function setCurrentItem()
	{
		if (isset($_REQUEST['i']))
		{
			$curr_item_id = self::getCurrentItem();
			if ($curr_item_id == $_REQUEST['i'])
			{
				// if we click on the item that is already current, unselect
				$_REQUEST['i'] = 0;
			}
			$story_data = Storydata::set('current_item',$_REQUEST['i']);			
			if (!Request::Current()->is_ajax())
			{    		
				// no javascript
				// refresh the page no matter what. 
				Request::Current()->redirect(Route::get('default')->uri(array('action'=>'scene')));
			}
		}
	}
	
	static public function dropCurrentItem()
	{
		$griditem_id = self::getCurrentItem();
		$story_data = Storydata::getStorydata();
		$s = Session::instance();
		$cell_id = ($s->get('story')->grid_total()-1);
		// put current item into the scene in the last cell
		Items::setGridItemLocation($griditem_id,$story_data['scene_id'],$cell_id); 
		if (Request::Current()->is_ajax())
		{   
			// 
			$act = new action_refreshitems();
			$results = $act->performAction();
			echo json_encode($results);
		}
		else
		{ 		
			// no javascript
			// refresh the page no matter what. 
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
