<?php 
/*
	Basic Inventory plugin for PointClickPress
 */

class plugin_inventory extends Model_Base_PCPPlugin
{	
	protected $label = 'Inventory'; // This is the label for this plugin
	protected $description = 'Basic inventory plugin for PCP'; // This is the description of this plugin
	protected $events = array(POST_START_STORY,CSS,ADMIN_JS,JS,DISPLAY_POST_SCENE,DISPLAY_POST_GRID_SELECT); // This is an array of events to call this plugin from
	
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
		}	
	}
	
	public function display()
	{
		include('inventory/display.php');
	}
	
	public function setCurrentItem()
	{
		if (isset($_REQUEST['i']))
		{
			$story_data = Storydata::set('current_item',$_REQUEST['i']);
			Request::$current->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}
	}
	
	static public function getCurrentItem()
	{
		return Storydata::get('current_item','');
	}
	
	static public function getInventory()
	{
		$inventory_items = array();
		$item_locations = Storydata::get('item_locations',array());
		if(isset($item_locations['inventory']))
		{
			$inventory_items = $item_locations['inventory'];
		}
		return $inventory_items;
	}
}
