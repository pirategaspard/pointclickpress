<?php 
/*
	Moves currently selected item from inventory and adds it to a scene
 */
define('INVENTORY_MOVE_ITEM','INVENTORY_MOVE_ITEM');
class action_inventorymove extends Model_Base_PCPActionDef
{	
	protected $label = 'Inventory Move Item'; 
	protected $description = 'Move item to arbitrary scene and cell id. Default item is currently selected inventory item. "scene_id,cell_id(,griditem_id)"';
	protected $allowed_action_types = array(ACTION_TYPE_GRID,ACTION_TYPE_GRIDITEM);
	protected $events = array(INVENTORY_MOVE_ITEM);
	
	public function performAction($args=array(),$hook_name='')
	{
		$action_data = $this->tokenize($args['action_value'],',');
		if (count($action_data) >= 2)
		{
			// you can specify a griditem_id, otherwise default is currently selected item
			if (count($action_data) ==3)
			{
				$griditem_id = $action_data[3];
			}
			else
			{
				$griditem_id = Storydata::get('current_item',0);
			}
			
			$scene_id = $action_data[0];
			$cell_id = $action_data[1];
			
			// if we have a selected griditem
			if($griditem_id > 0)
			{
				// put current item into a scene in a cell
				Items::setGridItemLocation($griditem_id,$scene_id,$cell_id); 
				Storydata::set('current_item',0);
			}
		}
		$story_data = Storydata::getStorydata();
		$refresh = new action_refreshitems;
		$results = $refresh->performAction($args,$story_data);
		return $results;
	}
}
?>
