<?php defined('SYSPATH') or die('No direct script access.');

Class Controller_Template_Admin extends Controller_Template_Base
{

	public $template = 'templates/admin';

	/**
	* Initialize properties before running the controller methods (actions),
	* so they are available to our action.
	*/
	public function before()
	{
	// Run anything that need ot run before this.
		parent::before();
		
		if ((Usersadmin::isloggedin())||((strcasecmp(Request::instance()->action,'login') == 0)||(strcasecmp(Request::instance()->action,'dologin') == 0)))
		{
			if($this->auto_render)
			{
				// Initialize empty values
				$this->template->title = 'PointClickPress - Admin';
				$this->template->message_console = '';
			}
		}
		else
		{	//redirect to login			
			Request::instance()->redirect(Route::get('admin')->uri(array('controller'=>'users','action'=>'Login')));	
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
