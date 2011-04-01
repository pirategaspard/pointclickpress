<?php 
/*
	Removes and item from a scene and adds it to inventory
 */
define('INVENTORY_ADD_ITEM','INVENTORY_ADD_ITEM');
class action_inventory_add extends Model_Base_PCPActionDef
{	
	
	protected $label = 'Add To Inventory'; 
	protected $description = 'Add item to inventory';
	protected $allowed_action_types = array(ACTION_TYPE_GRIDITEM);
	protected $events = array(INVENTORY_ADD_ITEM);
	
	public function performAction($args=array(),&$story_data=array(),$hook_name='')
	{
		if (isset($story_data['item_locations'][$story_data['scene_id']]['griditems'][$story_data['cell_id']]))
		{
			// get item out of item_locations array
			$item_info = $story_data['item_locations'][$story_data['scene_id']]['griditems'][$story_data['cell_id']];
			
			/* move item from current scene to inventory */
			// inventory is just a special key in the items_location array
			$story_data['item_locations']['inventory'][$item_info['id']] = $story_data['item_locations'][$story_data['scene_id']]['griditems'][$story_data['cell_id']];
			// remove item from scene
			unset($story_data['item_locations'][$story_data['scene_id']]['griditems'][$story_data['cell_id']]); 
		}
		$refresh = new action_refresh;
		$results = $refresh->performAction($args,$story_data);
		return $results;
	}
}
?>
