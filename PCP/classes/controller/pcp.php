<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_PCP extends Controller_Template_Base
{ 
    function action_index()
    {
        //$this->template->content = View::factory('/index')->render();
        $this->action_list_Stories();
    }
    
    /*
		This gets all the Interactive stories and 
		displays a list of them to the user
    */
    function action_list_Stories()
    {
		$data['stories'] = PCP::getStories();
        $this->template->content = View::factory('pcp/stories',$data)->render();
    }
    
    /*
		This gets a single Interactive story and
		displays its details to the user
    */
    function action_story()
    {
    	// set default story screen size
    	$session = Session::instance();	
    	$session->set('screen_width',DEFAULT_STORY_WIDTH);
		$session->set('screen_height',DEFAULT_STORY_HEIGHT);
    	
    
		$data['story'] = PCP::getStory();
		$data['screens'] = PCP::getScreens();
		$this->template->scripts = array_merge($this->template->scripts,PCP::getJSEventDefs());
		$this->template->scripts[] = 'screen.js'; //get screen js to determine user's screen resolution
		$this->template->title .= $data['story']->title;
		$this->template->top_menu = View::factory('pcp/story_menu',$data)->render(); 
        $this->template->content = View::factory('pcp/story',$data)->render();
    }
      
    /*
		Once a user has selected a story this function
		initalizes the story valiables and then displays the scene
    */
    function action_start_story()
    {
		if (isset($_REQUEST['story_id']))
		{			
		
			plugins::executeHook('pre_start_story');									
			// Get the current session
			$session = Session::instance();	
			// get user selected screen size
			if (isset($_POST['screens']))
			{				
				$screen = explode('x',$_POST['screens']);				
				$session->set('screen_width',$screen[0]);
				$session->set('screen_height',$screen[1]);
			}
			
			//get the story
			$story = PCP::getStory();
			// set the story dimensions
			$story->setDimensions($session->get('screen_width'),$session->get('screen_height'));			
			$session->set('story',$story);			
			
			// Empty old session data 												
			$story_data	= array();
			// set first location
			$story_data['location_id'] = $story->getFirstlocationId();
			// set new story data into session 
			$session->set('story_data',$story_data); 
			plugins::executeHook('post_start_story');									
			// put any story init events into session
			PCP::doEvents($story->events);			
			// redirect to the first scene
			Request::instance()->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}		
        else
        {
			// redirect to the story list page
			Request::instance()->redirect(Route::get('default')->uri(array('action'=>'list_stories')));
			//echo ("1- oops!");
		}
    }
    
    /*
		This function displays a scene to the user
    */
   	function action_scene()
    {    
		$results = array();
		
    	plugins::executeHook('pre_scene');	    
		// get session
		$session = Session::instance();			
		// get story
		$data['story'] = $session->get('story',NULL);																	
		//get location from session (so that we can process any location events)
		$story_data = $session->get('story_data');
		$location = PCP::getlocation($story_data['location_id']);	
		// put any location init events into session
		$results = array_merge($results,PCP::doEvents($location->events));
		
		// get the scene
		$data['scene'] = PCP::getScene(array('location_id'=>PCP::getCurrentlocationId(),'story'=>$data['story'],'simple_items'=>true));
		// put any scene init events into session
		$results = array_merge($results,PCP::doEvents($data['scene']->events));							
		//put scene into session
		$session->set('scene',$data['scene']);
		plugins::executeHook('post_scene');	
		
		// if we have valid data show the scene
		if (($data['story'] != NULL) && ($data['scene']->id > 0) && (strlen($data['scene']->filename) > 0))
		{			
			//$data['items'] = Model_items::builditemstatePaths(array('story'=>$data['story'],'items'=>$data['scene']->items));
			
			// Compose the scene 
			$this->template->scripts = array_merge($this->template->scripts,PCP::getJSEventDefs());			
			$this->template->scripts[] = 'grid.js'; //get grid js 
			$this->template->head[] = View::factory('pcp/style',$data)->render();//get grid style
			$this->template->title .= $data['story']->title.' : '.$data['scene']->title;
			$this->template->top_menu = View::factory('pcp/scene_menu',$data)->render();  			
			$data['grid'] = View::factory('pcp/grid',$data)->render(); //get grid
			// render the scene
			$data['scene_column_left'] = View::factory('pcp/scene_column_left',$data)->render();	
			$data['scene_column_right'] = View::factory('pcp/scene_column_right',$data)->render();
			$this->template->content = View::factory('pcp/scene',$data)->render();				
		}		
        else
        {
        	plugins::executeHook('error');
        
			// redirect to the story list page
			Request::instance()->redirect(Route::get('default')->uri(array('action'=>'list_stories')));
			
			/*
			//debug
			//	var_dump($_SESSION);
			if (($data['story'] == NULL))
			{
				echo ("No Story Data");				
			}
			if (($data['scene']->id <= 0) )
			{
				echo ("No scene id");				
			}
			if ( (strlen($data['scene']->filename) <= 0))
			{
				echo ("No filename");
				var_dump($data['scene']);
			}	
			*/
		}
    } 
  
    /* handles cell clicks */
    function action_cellClick()
    {
		// disable auto render	
	    $this->auto_render = FALSE;
    	plugins::executeHook('pre_cellClick');
    	// do the action (if any)
    	$results = PCP::getGridEvent();
    	plugins::executeHook('post_cellClick');
    
    	if (Request::$is_ajax)
    	{    		
			// display the results 	
			echo json_encode($results);	
			//(javascript will decide what to do next)	
		}
    	else 
    	{
    		// no javascript
    		// refresh the page no matter what. 
			Request::instance()->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}
	}
	
	function action_screenSize()
    {
		$this->auto_render = FALSE; // disable auto render
		if (isset($_POST['w'])&&isset($_POST['h']))
		{
			// get session
			$session = Session::instance();	
			$session->set('screen_width',$_POST['w']);
			$session->set('screen_height',$_POST['h']);
		}
	}
}

?>
