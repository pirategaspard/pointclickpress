<?php 
/*
	Removes and item from a scene and adds it to inventory
 */
define('INVENTORY_USE_ITEM','INVENTORY_USE_ITEM');
class action_inventory_use extends Model_Base_PCPActionDef
{	
	protected $label = 'Use Inventory Item'; 
	protected $description = 'Use item from inventory. "item_id,cell_id_to_trigger"';
	protected $allowed_action_types = array(ACTION_TYPE_GRID);
	protected $events = array(INVENTORY_USE_ITEM);
	
	public function performAction($args=array(),$hook_name='')
	{
		$results = parent::performAction($args);
		$story_data = Storydata::getStorydata();
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		foreach ($expressions as $expression)
		{
			$this->tokenize($expression,',');
			
			if (count($expression)==2)
			{
				$item_id = $expression[0];
				$cell_to_click = $expression[1];			
				if (plugin_inventory::getCurrentItem()==$item_id)
				{
					// if the current item in inventory matches the item id we trigger a cell click 
					$args = array('action_value'=>"0,$cell_to_click;");
					$t = new Action_eventtimer();
					$results = $t->performAction($args);
					// below should work, but instead dies with Out of Mem error. Something to do with session?				
					//$results = Request::factory(Route::get('default')->uri(array('controller'=>'PCP','action'=>'cellClick'));)->query('n',$cell_to_click)->execute()->body();				
					
				}
			}
		}
		return $results;
	}
}
?>
