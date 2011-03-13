<?php 
/*
	Basic Inventory plugin for PointClickPress
 */

class plugin_inventory extends Model_Base_PCPPlugin
{	
	public function __construct()
	{
		// init this event
		parent::__construct();
		$this->label = 'Inventory';
		$this->description = 'Basic inventory plugin for PCP';
		$this->hooks = 'post_start_story,css,js,display_post_scene';	
	}
	
	public function execute($hook_name='')
	{
		switch($hook_name)
		{
			case 'post_start_story':
			{
				// init current item in session
				$session = Session::instance();			
				$story_data = $session->get('story_data',array());
				$story_data['current_item'] = 0;
				$session->set('story_data',$story_data);
			}
			case 'css':
			{
				include('inventory/css.php');
				break;
			}case 'js':
			{
				include('inventory/js.php');
				break;
			}	
			case 'display_post_scene':
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
