<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_Admin extends Controller_Template_Base
{
	public $auth_required = 'login';
	public $secure_actions = array();
	
	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{
		// Run anything that need ot run before this.
		$this->template = 'templates/admin';
		parent::before();
		Model_Admin_EventsAdmin::initalizeListenerClasses(); // initalize events engine
		Events::announceEvent(ADMIN_REQUEST_START);		

		if($this->auto_render)
		{
			// we need this info to make the wiki help link
			$data['action'] = Request::current()->action();			
			$data['controller'] = Request::current()->controller();
			$data['directory'] = Request::current()->directory();
			
			// Initialize values
			$this->template->title = DEFAULT_PAGE_TITLE.' Admin';
			$this->template->scripts = array('jquery-1.4.2.min.js','jquery-ui-1.8.6.custom.min.js','thickbox-compressed.js','pcpadmin.js');
			$this->template->styles = array('pcp-ui/jquery-ui-1.8.6.custom.css','thickbox.css','pcpadmin.css');
			$this->template->header = View::factory('/admin/header')->render();
			$this->template->breadcrumb = '';
			$this->template->top_menu = View::factory('/admin/top_menu',$data)->render();
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
		
		// decide if we have a result and how to display it
		$session = Session::instance();
		$result = $session->get('result');		
		if ($result)
		{
			if ($result->success)
			{				
				//$this->template->messages = "Success";
				$this->template->messages = '<p class="'.$result->getClass().'">'.$result->message.'</p>';				
			}
			elseif ($result->success == 0)
			{
				//$this->template->messages = "Failed";
				$this->template->messages = '<p class="'.$result->getClass().'">'.$result->message.'</p>';					
			}
			elseif ($result->success < 0)
			{
				$this->template->messages = "No Action";
				//$this->template->messages = $result->message;				
			}
		}
		$session->delete('result');	
	}
}
?>
