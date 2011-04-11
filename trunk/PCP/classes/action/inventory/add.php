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
	
	public function performAction($args=array(),$hook_name='')
	{
		$story_data = Storydata::getStorydata();
		$item_info = Items::getGriditemBySceneIdAndCellId($story_data['scene_id'],$story_data['cell_id']);
		if (count($item_info) > 0)
		{
			/* move item from current scene to inventory */
			// inventory is just a special key in the items_location array	
			Items::setGridItemLocation($item_info['id'],'inventory',$item_info['id']);			
		}
		$refresh = new action_refreshitems;
		$results = $refresh->performAction($args,$story_data);
		return $results;
	}
}
?>
