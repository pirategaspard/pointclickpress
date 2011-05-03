<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_Admin extends Controller_Template_Base
{
	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{
	// Run anything that need ot run before this.
		parent::before();
		Model_Admin_EventsAdmin::initalizeListenerClasses(); // initalize events engine
		$this->template = new View('templates/admin');
		
		if ((Model_Admin_Usersadmin::isloggedin())||((strcasecmp(Request::Current()->action(),'login') == 0)||(strcasecmp(Request::Current()->action(),'dologin') == 0)||(strcasecmp(Request::Current()->controller(),'install') == 0)))
		{
			if($this->auto_render)
			{
				// Initialize values
				$this->template->title = DEFAULT_PAGE_TITLE.' Admin';
				$this->template->scripts = array('jquery-1.4.2.min.js','jquery-ui-1.8.6.custom.min.js','thickbox-compressed.js','pcpadmin.js');
				$this->template->styles = array('pcp-ui/jquery-ui-1.8.6.custom.css','thickbox.css','pcpadmin.css');
				$this->template->header = View::factory('/admin/header')->render();	;
				$this->template->breadcrumb = '';
				$this->template->messages = '';
				$this->template->footer = View::factory('admin/footer')->render();
			}
		}
		else
		{	//redirect to login			
			Request::Current()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'Login')));	
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
