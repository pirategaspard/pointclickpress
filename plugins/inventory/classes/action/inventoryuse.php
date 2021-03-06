<?php 
/*
	Removes and item from a scene and adds it to inventory
 */
define('INVENTORY_USE_ITEM','INVENTORY_USE_ITEM');
class action_inventoryuse extends Model_Base_PCPActionDef
{	
	protected $label = 'Inventory Use Item'; 
	protected $description = 'Use item from inventory. "item_id,cell_id_to_trigger"';
	protected $allowed_action_types = array(ACTION_TYPE_GRID,ACTION_TYPE_GRIDITEM);
	protected $events = array(INVENTORY_USE_ITEM);
	
	public function performAction($args=array(),$hook_name='')
	{
		$results = parent::performAction($args);
		$story_data = Storydata::getStorydata();
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		foreach ($expressions as $expression)
		{
			$use_item_statement = $this->tokenize($expression,',');
			if (count($use_item_statement)==2)
			{
				$item_id = $use_item_statement[0];
				$cell_to_click = $use_item_statement[1];		
				if (plugins_inventory::getCurrentItem()==$item_id)
				{
					// if the current item in inventory matches the item id we trigger a cell click 
					/*$args = array('action_value'=>"0,$cell_to_click;");
					$t = new Action_eventtimer();
					$results = $t->performAction($args);*/
					// below should work, but instead dies with Out of Mem error. Something to do with session?				
					//$results = Request::factory(Route::get('default')->uri(array('controller'=>'PCP','action'=>'cellClick'));)->query('n',$cell_to_click)->execute()->body();				
					$session = Session::instance();					
					// get the scene_id
					$scene = $session->get('scene',NULL);
					// get scene id & set scene id into story_data
					$scene_id = ($scene != NULL)?$scene->id:0;

					Storydata::set('scene_id',$scene_id);
					Storydata::set('cell_id',$cell_to_click);    	    	    	
					Storydata::set('griditem_id',0); // set item id to 0 					
					// do the grid action (if any)
					$results = Actions::doActions(Actions::getCellActions(array('scene_id'=>Storydata::get('scene_id'),'cell_id'=>Storydata::get('cell_id'))));	
				}
			}
		}
		return $results;
	}
}
?>
