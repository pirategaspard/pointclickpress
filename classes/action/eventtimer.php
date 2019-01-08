<?php 
/*
 */
define('EVENTTIMER','EVENTTIMER'); // our event name
class action_eventtimer extends Model_Base_PCPActionDef
{
	protected $label = 'Event Timer';
	protected $description = 'Execute a timed click on a cell. Can be used to execute timed events. usage: wait_time,cell_to_click';	

	public function performAction($args=array(),$hook_name='')
	{
		$expressions = $this->tokenize($args['action_value']); // explode on semi-colon if there is more than one statement here
		//foreach ($expressions as $expression) // sorry only 1 timer right now, will fix this later
		if (count($expressions) > 0)
		{
			$timer_data = explode(',',$expressions[0]);
			$data = array();
			$data['wait_time'] = $timer_data[0];
			$data['cell_to_click'] = $timer_data[1];
		}
		// return message response
		$response = new pcpresponse(EVENTTIMER,$data); 
		return $response->asArray();
	}
}
?>

