<?php 
/*
	Basic Inventory plugin for PointClickPress
 */

class plugin_inventory extends Model_Base_PCPPlugin
{	
	
	protected $label = 'Inventory'; // This is the label for this plugin
	protected $description = 'Basic inventory plugin for PCP'; // This is the description of this plugin
	protected $events = array(POST_START_STORY,CSS,JS,DISPLAY_POST_SCENE); // This is an array of events to call this plugin from
	
	
	public function execute($event_name='')
	{
		switch($event_name)
		{
			case POST_START_STORY:
			{
				// init current item in session
				$session = Session::instance();			
				$story_data = $session->get('story_data',array());
				$story_data['current_item'] = 0;
				$session->set('story_data',$story_data);
			}
			case CSS:
			{
				include('inventory/css.php');
				break;
			}case JS:
			{
				include('inventory/js.php');
				break;
			}	
			case DISPLAY_POST_SCENE:
			{
				include('inventory/link.php');
				break;
			}	
		}	
	}
	
	public function display()
	{
		include('inventory/display.php');
	}
	
	public function setCurrentItem()
	{
		if (isset($_REQUEST['i']))
		{
			$session = Session::instance();			
			$story_data = $session->get('story_data',array());
			$story_data['current_item'] = $_REQUEST['i'];
			$session->set('story_data',$story_data);
			Request::instance()->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}
	}
}
