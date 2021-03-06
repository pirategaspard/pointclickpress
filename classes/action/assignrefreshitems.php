<?php 
/*
	Basic session variable assignment class for PointClickPress.	 
	Examples:	
	$door_open = 1;
	$visits = $visits + 1;
	$mylocation = 'NORTH'; //Remember that location slugs are session variables that can be assigned a scene value!
 */

class action_assignrefreshitems extends action_assign
{	
	protected $label = 'Assign value and item refresh';
	protected $description = 'Assign a new value to a session variable then refresh any items. Example: $door_open = 1;';
	protected $allowed_action_types = array(ACTION_TYPE_GRID,ACTION_TYPE_GRIDITEM);	
	
	private $story_data = array();
	
	public function performAction($args=array(),$hook_name='')
	{
		$results = parent::performAction($args);	
		$refresh = new action_refreshitems;
		$results = $refresh->performAction($args);
		return $results;
	}
}
?>
