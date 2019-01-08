<?php 
/*
	Removes and item from a scene and adds it to inventory
 */
define('POINTS_ADD','POINTS_ADD');
define('POINTS_REFRESH','REFRESH_POINTS');
class action_points extends Model_Base_PCPActionDef
{	
	protected $label = 'Points: Add Points'; 
	protected $description = 'Add points to game points total. Default is 1 point.';
	protected $allowed_action_types = array(ACTION_TYPE_GRID);
	protected $events = array('ACTION_REFRESH_EVENT');
	
	public function performAction($args=array(),$hook_name='')
	{
		$old_points = Storydata::get('_plugin_points',0);
	
		// refresh points on reload
		if ($hook_name=='ACTION_REFRESH_EVENT')
		{
			$points = $old_points;
		}
		else
		{
			// increment points
			$story_data = Storydata::getStorydata();
			if ($this->isNumeric($args['action_value']))
			{
				$points = $old_points + $args['action_value'];
			}
			else
			{
				$points = $old_points + 1;
			}
			
			// simple assignment, just update the location id 
			Storydata::set('_plugin_points',$points);								
		}
		// tell js to refresh points 
		$data['points'] = $points;
		$response = new pcpresponse(POINTS_REFRESH,$data);
		$results = $response->asArray();
		return $results;
	}
}
?>
