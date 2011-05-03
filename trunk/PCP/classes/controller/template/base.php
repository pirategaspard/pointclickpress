<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_Base extends Controller_Template
{

	public $template = 'templates/simple';

	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{
	// Run anything that need to run before this.
		parent::before();
		Events::initalizeListenerClasses(); // initalize events engine
		
		if($this->auto_render)
		{
			// Initialize empty values
			$this->template->title = DEFAULT_PAGE_TITLE;
			$this->template->scripts = array('jquery-1.4.2.min.js','jquery-ui-1.8.6.custom.min.js');
			$this->template->styles = array('pcp-ui/jquery-ui-1.8.6.custom.css');
			$this->template->head = array();
			$this->template->header = '';
			$this->template->top_menu = '';
			$this->template->content = '';
			$this->template->bottom_menu = '';
			$this->template->footer = '';
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
	
	protected function simple_output()
	{
		$this->template = new View('templates/simple');
	}

}

?>
