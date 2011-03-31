<?php 
/*
	Removes and item from a scene and adds it to inventory
 */

class action_inventory_add extends action_refreshitems
{	
	public function __construct()
	{
		// init this action
		parent::__construct();
		$this->label = 'Add To Inventory';
		$this->description = 'Add item to inventory';	
		$this->allowed_action_types = array(ACTION_TYPE_GRIDITEM);	
	}
	
	public function execute($args=array(),&$story_data=array())
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
		return parent::execute($args,$story_data);
	}
}
?>