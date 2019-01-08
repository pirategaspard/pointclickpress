<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_PCP extends Controller_Template_Base
{
	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{
		// Run anything that need to run before this.
		if (strcasecmp(Request::Current()->action(),'scene') == 0) //|| (strcasecmp(Request::Current()->action(),'story') == 0)) 
		{	
			// if we are displaying a scene use the theme
			$data = Model_PCP_Themes::getData();
		}
		else
		{
			// otherwise always use the default theme
			$data = array('theme_name'=>'default');
		}
		Model_PCP_Themes::setTheme($data);	
		$this->template = 'templates/pcp';
		parent::before();
		Model_Utils_ModuleHelper::loadModules(); // load Modules
		Events::initalizeListenerClasses(); // initalize events engine
		Events::announceEvent(PCP_REQUEST_START);
		

		if($this->auto_render)
		{
			// Initialize empty values
			$this->template->title = DEFAULT_PAGE_TITLE;
			$this->template->scripts = array('jquery-1.4.2.min.js','jquery-ui-1.8.6.custom.min.js');
			$this->template->styles = array('pcp-ui/jquery-ui-1.8.6.custom.css');
			$this->template->theme_styles = Model_PCP_Themes::getStyles($data);
			$this->template->theme_scripts = Model_PCP_Themes::getScripts($data);
			$this->template->head = array();
			$this->template->header = View::factory('pcp/header')->render();
			$this->template->top_menu = '';
			$this->template->content = '';
			$this->template->bottom_menu = '';
			$this->template->footer = View::factory('pcp/footer')->render();
		}
	}

	/**
	* Fill in default values for our properties before rendering the output.
	*/
	public function after()
	{
		// Run anything that needs to run after this.
		parent::after();
	}
}

?>
