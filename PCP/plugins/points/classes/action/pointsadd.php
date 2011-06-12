<?php 
/*
	Removes and item from a scene and adds it to inventory
 */
define('POINTS_ADD','POINTS_ADD');
class action_pointsadd extends Model_Base_PCPActionDef
{	
	protected $label = 'Points: Add Points'; 
	protected $description = 'Add points to game points total. Default is 1 point.';
	protected $allowed_action_types = array(ACTION_TYPE_GRID);
	
	public function performAction($args=array(),$hook_name='')
	{
		$story_data = Storydata::getStorydata();
		if ($this->isNumeric($args['action_value']))
		{
			$points = $args['action_value'];
		}
		else
		{
			$points = 1;
		}
		
		// simple assignment, just update the location id 
		Storydata::set('_plugin_points',$points);
		// pass to the parent action to refresh the scene
		$results = parent::performAction($args);		
		return $results;
	}
}
?>
