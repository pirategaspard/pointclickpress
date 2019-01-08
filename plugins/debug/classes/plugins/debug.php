<?php defined('SYSPATH') or die('No direct script access.');

/*
	Basic debuging plugin for PointClickPress
 */

class plugins_debug extends Model_Base_PCPPlugin
{
	protected $label = 'Debug'; // This is the label for this plugin
	protected $description = 'Debug Plugin for PCP. Add "?debug" on the url to see debug information'; // This is the description of this plugin
	protected $events = array(DISPLAY_POST_SCENE,ERROR); // This is an array of events to call this plugin from
		
	public function execute($event_name='')
	{
		// did we pass 'debug' on the url?
		if (isset($_GET['debug']))
		{
			//add or update any values passed on the url			
			foreach ($_GET as $name=>$value)
			{
				Storydata::set($name,$value);
			}			
								
			/* Add what ever you want to dump out of session here */			
			$story_data = Storydata::getStorydata();
			?>
			<pre>
				<?php var_dump($story_data);?>
			</pre>
			
			<style>
				#grid a {margin: -1px; padding: -1px; border: 1px solid red; }
			</style> 
			
			<?php
			
			if($event_name == ERROR)
			{
				//die();
			}
			
			/*
			$session = Session::instance();	
			$story = $session->get('story',array());
			$scene = $session->get('scene',array());														
			echo $story->scene_width;
			echo $story->scene_height;	
			echo('screen dimensions'.$_SESSION['screen_width'].'x'.$_SESSION['screen_height']);
			*/
		}
	}
}

?>
