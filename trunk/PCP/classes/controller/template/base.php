<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_Base extends Controller_Template
{

	public $template = 'templates/simple';
	public $auth_required = FALSE;
	public $secure_actions = FALSE;
	
	public function access_required() 
	{
      $this->request->redirect('user/noaccess');
	}
	
	public function login_required() 
	{
      Request::current()->redirect('admin/user/login');
	}

	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{		
		try 
		{
			$this->session = Session::instance();
		} catch(ErrorException $e) 
		{
			session_destroy();
		}		
		
		// Run anything that need to run before this.
		parent::before();
		Model_Utils_ModuleHelper::loadModules(); // load Modules
		Events::initalizeListenerClasses(); // initalize events engine
		
		// Open session
		$this->session = Session::instance();

		// Check user auth and role
		$action_name = Request::current()->action();

		if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)// auth is required AND user role given in auth_required is NOT logged in				
			|| (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE))// OR secure_actions is set AND the user role given in secure_actions is NOT logged in
		{
			if (Auth::instance()->logged_in())
			{
				// user is logged in but not on the secure_actions list
				$this->access_required();
			} 
			else 
			{
				$this->login_required();
			}
		}

		if ($this->auto_render) 
		{
		
			// Initialize empty values
			$this->template->title = DEFAULT_PAGE_TITLE;
			$this->template->styles = array('pcp-ui/jquery-ui-1.8.6.custom.css');
			$this->template->scripts = array('jquery-1.4.2.min.js','jquery-ui-1.8.6.custom.min.js');			
			$this->template->theme_styles = array();
			$this->template->theme_scripts = array();
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
