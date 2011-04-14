<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_PCP extends Controller_Template_PCP
{ 
    function action_index()
    {
        $this->action_list_Stories();
    }
    
    /*
		This gets all the Interactive stories and 
		displays a list of them to the user
    */
    function action_list_Stories()
    {
		$data['stories'] = Model_PCP_Stories::getStories(array('status'=>'p'));
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
    	$session->set('screen_width',DEFAULT_SCREEN_WIDTH);
		$session->set('screen_height',DEFAULT_SCREEN_HEIGHT);	
    
		$data['story'] = Model_PCP_PCP::getStory();
		$data['screens'] = Model_PCP_Screens::getScreens();
		$this->template->scripts = array_merge($this->template->scripts,Model_PCP_Actions::getJSActionDefs());
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
			Events::announceEvent(PRE_START_STORY);									
			// Get the current session
			$session = Session::instance();	
			//set story id into session
			$session->set('story_id',$_REQUEST['story_id']);
			// get user selected screen size
			if (isset($_POST['screens']))
			{				
				$screen = explode('x',$_POST['screens']);				
				$session->set('screen_width',$screen[0]);
				$session->set('screen_height',$screen[1]);
			}
			
			//get the story
			$story = Model_PCP_Stories::getStoryInfo(array('id'=>$session->get('story_id',0)));
			// set the story dimensions
			$story->setDimensions($session->get('screen_width'),$session->get('screen_height'));			
			$session->set('story',$story);	
			// Empty old story data 												
			Storydata::setStorydata();
			// get inital item info 
			$item_info = $story->initItems();
			// set default item states
			Storydata::setStorydata($item_info['item_data']); // init story data with the item data 
			// set item locations
			Storydata::set('item_locations',$item_info['item_locations']); 
			// set first location
			Storydata::set('location_id',$story->getFirstlocationId());
			// set story id
			Storydata::set('story_id',$story->id);
			Events::announceEvent(POST_START_STORY);									
			// put any story init actions into session
			Model_PCP_Actions::doActions($story->getActions());			
			// redirect to the first scene
			Request::Current()->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}		
        else
        {
			// redirect to the story list page
			Request::Current()->redirect(Route::get('default')->uri(array('action'=>'list_stories')));
		}
    }
    
    /*
		This function displays a scene to the user
    */
   	function action_scene()
    {    
		$results = array();
		
	    Events::announceEvent(PRE_SCENE);	    
		// get session
		$session = Session::instance();			
		// get story
		$data['story'] = $session->get('story',NULL);																	
		//get location from session (so that we can process any location actions)
		$location =  Model_PCP_Locations::getlocation(array('id'=>Storydata::get('location_id')));	
		// put any location init actions into session
		$results = array_merge($results,Actions::doActions($location->getActions()));
		
		// get the scene
		$data['scene'] = Model_PCP_Scenes::getCurrentScene(array('location_id'=>Model_PCP_Locations::getCurrentlocationId()));//,'story'=>$data['story']));		
		$data['items'] = Model_PCP_Items::getSceneGriditems($data['scene']->id);
		
		// put any scene init actions into session
		$results = array_merge($results,Actions::doActions($data['scene']->getActions()));	
		// put any item actions into session
		$results = array_merge($results,Actions::doActions(Model_PCP_Actions::getSceneItemActions($data['scene']->id)));	
		
		//put scene into session
		$session->set('scene',$data['scene']);
		//put scene id into story_data
		Storydata::set('scene_id',$data['scene']->id);
		
		// if we have valid data show the scene
		if (($data['story'] != NULL) && ($data['scene']->id > 0) && (strlen($data['scene']->filename) > 0))
		{	
			// Compose the scene 
			$this->template->scripts = array_merge($this->template->scripts,Model_PCP_Actions::getJSActionDefs());			
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
        	Events::announceEvent(ERROR);
        
			// redirect to the story list page
		//	Request::Current()->redirect(Route::get('default')->uri(array('action'=>'list_stories')));
			//debug
			//var_dump($_SESSION);
			if (($data['story'] == NULL))
			{
				echo ("<b>No Story Data</b>");				
			}
			if (($data['scene']->id <= 0) )
			{
				echo ("<b>No Scene id</b>");				
			}
			if ( (strlen($data['scene']->filename) <= 0))
			{
				echo ("<b>No Filename</b>");			
			//	var_dump($data['scene']);
			}	
		}
		Events::announceEvent(POST_SCENE);	
    } 
  
    /* handles cell clicks */
    function action_cellClick()
    {		
		$this->simple_output();
		// do plugins
    	Events::announceEvent(PRE_CELL_CLICK);
    	// get session
		$session = Session::instance();
		
		// get the scene_id
		$scene = $session->get('scene',NULL);
		// get scene id & set scene id into story_data
		$scene_id = ($scene != NULL)?$scene->id:0;
		// get cell id that was clicked & set cell id into story_data
    	$cell_id = (isset($_REQUEST['n']))?$_REQUEST['n']:0;
    	
    	Storydata::set('scene_id',$scene_id);
    	Storydata::set('cell_id',$cell_id);    	    	    	
    	Storydata::set('griditem_id',0); // set item id to 0 
    	
    	// do the grid action (if any)
    	$results = Actions::doActions(Actions::getCellActions(array('scene_id'=>Storydata::get('scene_id'),'cell_id'=>Storydata::get('cell_id'))));
    	//get item location info
		$item_locations = Items::getSceneGridItemInfo(Storydata::get('scene_id'),Storydata::get('item_locations'));
    	// do plugins
    	Events::announceEvent(POST_CELL_CLICK);
		
    	if (Request::Current()->is_ajax())
    	{    	
			// display the results 	
			$this->template->content = json_encode($results);	
			//(javascript will decide what to do next)	
		}
		else 
    	{
    		// no javascript - refresh the page no matter what. 
			Request::Current()->redirect(Route::get('default')->uri(array('action'=>'scene')));
		}
    }
	
    /* handles cell clicks */
    function action_itemClick()
    {		
		$this->simple_output();
	    // do plugins
	    Events::announceEvent(PRE_ITEM_CLICK);
    	Events::announceEvent(PRE_CELL_CLICK);
    	// get session
		$session = Session::instance();
		// get the scene_id
		$scene = $session->get('scene',NULL);
		// get scene id & set scene id into story_data
		$scene_id = ($scene != NULL)?$scene->id:0;
		// get cell id that was clicked & set cell id into story_data
    	$cell_id = (isset($_REQUEST['n']))?$_REQUEST['n']:0;
    	// get item id that was clicked & set item id into story_data
    	$griditem_id = (isset($_REQUEST['i']))?$_REQUEST['i']:0;
    	
    	Storydata::set('scene_id',$scene_id);
    	Storydata::set('cell_id',$cell_id);    	    	    	
    	Storydata::set('griditem_id',$griditem_id);
    	
    	// do item action (if any)
    	$results = Actions::doActions(Actions::getGridItemActions(array('griditem_id'=>Storydata::get('griditem_id'),'scene_id'=>Storydata::get('scene_id'))));
		// do plugins
		Events::announceEvent(POST_CELL_CLICK);
		Events::announceEvent(POST_ITEM_CLICK);
 
    	if (Request::Current()->is_ajax())
    	{    		
			// display the results 	
			$this->template->content = json_encode($results);	
			//(javascript will decide what to do next)	
		}
		else 
    	{
    		// no javascript - refresh the page no matter what. 
			Request::Current()->redirect(Route::get('default')->uri(array('action'=>'scene')));
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
	
	// executes a function in a registered plugin class 
/*	function action_plugin()
	{
		$this->simple_output();
		// get plugin
		$plugin = Plugins::getPlugin(array('plugin'=>$_REQUEST['plugin']));
		if(count($plugin) > 0)
		{
			// get class
			$p = new $plugin[0]['class'];
			// if method exists, execute
			if (method_exists($p,$_REQUEST['f']))
			{
				// execute function
				$this->template->content = $p->$_REQUEST['f']();
			}
			else
			{
				// fail silently
				$this->template->content = '';
			}	
		}
	}*/
	
	// announce an event from the url
	function action_announceEvent()
	{
		$this->auto_render = FALSE;
		if(strlen($_REQUEST['event']))
		{
			Events::announceEvent($_REQUEST['event']);
		}
	}
}

?>
