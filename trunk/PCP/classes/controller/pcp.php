<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_PCP extends Controller_Template_Base
{ 
    function action_index()
    {
        $this->template->content = View::factory('/index')->render();
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
		$data['story'] = PCP::getStory();
		$this->template->scripts = array_merge($this->template->scripts,PCP::getJSEventTypes());
		$this->template->scripts[] = 'screen.js'; //get screen js to determine user's screen resolution 
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
			pluginadmin::executeHook('pre_start_story');									
			// Get the current session
			$session = Session::instance();	
			
			//get the story
			$story = PCP::getStory();
			// set the story dimensions
			$story->setDimensions($session->get('screen_width'),$session->get('screen_height'));			
			$session->set('story',$story);			
			
			// Empty old session data 												
			$story_data	= array();
			// set first container
			$story_data['container_id'] = $story->getFirstContainerId();
			// set new story data into session 
			$session->set('story_data',$story_data); 
			pluginadmin::executeHook('post_start_story');									
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
		
    	pluginadmin::executeHook('pre_scene');	    
		// get session
		$session = Session::instance();			
		// get story
		$data['story'] = $session->get('story',NULL);						
		// get the scene
		$data['scene'] = PCP::getScene(PCP::getCurrentContainerId());										
		
		//get container from session (so that we can process any container events)
		$container = $session->get('container',NULL);
		if (!isset($container)||($container->id != $data['scene']->container_id))
		{
			$container = PCP::getContainer($data['scene']->container_id);
		}								
				
		// put any container init events into session
		$results = array_merge($results,PCP::doEvents($container->events));
		// put any scene init events into session
		$results = array_merge($results,PCP::doEvents($data['scene']->events));							
		//put scene into session
		$session->set('scene',$data['scene']);
		pluginadmin::executeHook('post_scene');	
		
		// if we have valid data show the scene
		if (($data['story'] != NULL) && ($data['scene']->id > 0) && (strlen($data['scene']->filename) > 0))
		{				
			if (Request::$is_ajax)
    		{
    			// disable auto render
    			$this->auto_render = FALSE;
    			// create response
    			$JSON['filename'] = $data['scene']->getPath($data['story']->scene_width,$data['story']->scene_height);
    			$JSON['title'] = $data['scene']->title;
    			$JSON['description'] = $data['scene']->description;
    			
    			$response = new pcpresponse(REFRESH,$JSON);
				$results = array_merge($results,$response->asArray());
    			
    			// return data as JSON
				//echo json_encode($JSON);
				echo json_encode($results);
    		}
    		else
    		{
				// Compose the scene 
				$this->template->scripts = array_merge($this->template->scripts,PCP::getJSEventTypes());			
				$this->template->scripts[] = 'grid.js'; //get grid js 
				$this->template->head[] = View::factory('pcp/style',$data)->render();//get grid style
				$this->template->title .= $data['story']->title.' : '.$data['scene']->title; 			
				$data['grid'] = View::factory('pcp/grid',$data)->render(); //get grid
				// render the scene
				$this->template->content = View::factory('pcp/scene',$data)->render();
			}
		}		
        else
        {
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
    	pluginadmin::executeHook('pre_cellClick');
    	// do the action (if any)
    	$results = PCP::getGridEvent();
    	pluginadmin::executeHook('post_cellClick');
    
    	if (Request::$is_ajax)
    	{
    		// disable auto render	
	    	$this->auto_render = FALSE;
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
	
	function action_API()
	{
		// disable auto render	
	    $this->auto_render = FALSE;
		if (Request::$is_ajax)
    	{
    		// get session
			$session = Session::instance();	
			$story_data = $session->get('story_data',array());			
    		// intersect request variables with session to get response
    		$JSON = array_intersect_key($story_data,$_REQUEST);
    		// send back the data as JSON
    		echo json_encode($JSON);
    	}
	}
}

?>
