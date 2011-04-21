<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_Install extends Controller_Template
{

	public $template = 'templates/admin';

	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{
	// Run anything that need to run before this.
		parent::before();

		// Can't initalize here because we are installing and these will not exist!
		//Events::initalizeListenerClasses(); // initalize events engine
		
		if($this->auto_render)
		{
			// Initialize empty values
			$this->template->title = DEFAULT_PAGE_TITLE.' Admin';
			$this->template->scripts = array('jquery-1.4.2.min.js','jquery-ui-1.8.6.custom.min.js','thickbox-compressed.js','pcpadmin.js');
			$this->template->styles = array('pcp-ui/jquery-ui-1.8.6.custom.css','thickbox.css','pcpadmin.css');
			$this->template->header = '';
			$this->template->top_menu = '';
			$this->template->content = '';
			$this->template->bottom_menu = '';
			$this->template->breadcrumb = '';
			$this->template->messages = '';
			$this->template->footer = View::factory('admin/footer')->render();									
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
