<?php defined('SYSPATH') or die('No direct script access.');

/**
 * App controller class.
 *
 * @author Mikito Takada
 * @package default
 * @version 1.0
 */
class Controller_Template_App extends Controller {


   /**
    * @var string Filename of the template file.
    */
   public $template = 'template/default';

   /**
    * @var boolean Whether the template file should be rendered automatically.
    * 
    * If set, then the template view set above will be created before the controller action begins.
    * You then need to just set $this->template->content to your content, without needing to worry about the containing template.
    *
    **/
   public $auto_render = TRUE;

   /**
    * Controls access for the whole controller, if not set to FALSE we will only allow user roles specified
    *
    * Can be set to a string or an array, for example array('login', 'admin') or 'login'
    */
   public $auth_required = FALSE;

   /** Controls access for separate actions
    * 
    *  Examples:
    * 'adminpanel' => 'admin' will only allow users with the role admin to access action_adminpanel
    * 'moderatorpanel' => array('login', 'moderator') will only allow users with the roles login and moderator to access action_moderatorpanel
    */
   public $secure_actions = FALSE;

   /**
    * Called from before() when the user does not have the correct rights to access a controller/action.
    *
    * Override this in your own Controller / Controller_App if you need to handle
    * responses differently.
    *
    * For example:
    * - handle JSON requests by returning a HTTP error code and a JSON object
    * - redirect to a different failure page from one part of the application
    */
   public function access_required() {
      $this->request->redirect('user/noaccess');
   }

   /**
    * Called from before() when the user is not logged in but they should.
    *
    * Override this in your own Controller / Controller_App.
    */
   public function login_required() {
      Request::current()->redirect('user/login');
   }

   /**
    * The before() method is called before your controller action.
    * In our template controller we override this method so that we can
    * set up default values. These variables are then available to our
    * controllers if they need to be modified.
    *
    * @return  void
    */
   public function before() {
      // This codeblock is very useful in development sites:
      // What it does is get rid of invalid sessions which cause exceptions, which may happen
      // 1) when you make errors in your code.
      // 2) when the session expires!
      try {
         $this->session = Session::instance();
      } catch(ErrorException $e) {
         session_destroy();
      }
      // Execute parent::before first
      parent::before();
      // Open session
      $this->session = Session::instance();

      // Check user auth and role
      $action_name = Request::current()->action();

      if (($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
            // auth is required AND user role given in auth_required is NOT logged in
            || (is_array($this->secure_actions) && array_key_exists($action_name, $this->secure_actions) && Auth::instance()->logged_in($this->secure_actions[$action_name]) === FALSE)
            // OR secure_actions is set AND the user role given in secure_actions is NOT logged in
         ) {
         if (Auth::instance()->logged_in()){
            // user is logged in but not on the secure_actions list
            $this->access_required();
         } else {
            $this->login_required();
         }
      }

      if ($this->auto_render) {

         // only load the template if the template has not been set..
         $this->template = View::factory($this->template);
         
         // Initialize empty values
         // Page title
         $this->template->title   = '';
         // Page content
         $this->template->content = '';
         // Styles in header
         $this->template->styles = array();
         // Scripts in header
         $this->template->scripts = array();
         // ControllerName will contain the name of the Controller in the Template
         $this->template->controllerName = $this->request->controller();
         // ActionName will contain the name of the Action in the Template
         $this->template->actionName = $this->request->action();
         // next, it is expected that $this->template->content is set e.g. by rendering a view into it.
     }
   }
   
      /**
    * View: Login form.
    */
   public function action_login() {
      // ajax login
      if($this->request->is_ajax() && isset($_REQUEST['username'], $_REQUEST['password'])) {
         $this->auto_render = false;
         $this->request->headers('Content-Type', 'application/json');
         if(Auth::instance()->logged_in() != 0) {
            $this->response->status(200);
            $this->template->content = $this->request->body('{ "success": "true" }');
            return;
         }
         else if( Auth::instance()->login($_REQUEST['username'], $_REQUEST['password']) )
         {
            $this->response->status(200);
            $this->template->content = $this->request->body('{ "success": "true" }');
            return;
         }
         $this->response->status(500);
         $this->template->content = $this->request->body('{ "success": "false" }');
         return;
      } else {
         // set the template title (see Controller_App for implementation)
         $this->template->title = __('Login');
         // If user already signed-in
         if(Auth::instance()->logged_in() != 0){
            // redirect to the user account
            $this->request->redirect('user/profile');
         }
         $view = View::factory('user/login');
         // If there is a post and $_POST is not empty
         if ($_REQUEST && isset($_REQUEST['username'], $_REQUEST['password'])) {

            // Check Auth if the post data validates using the rules setup in the user model
            if ( Auth::instance()->login($_REQUEST['username'], $_REQUEST['password']) ) {
               // redirect to the user account
               $this->request->redirect('user/profile');
               return;
            } else {
               $view->set('username', $_REQUEST['username']);
               // Get errors for display in view
               $validation = Validation::factory($_REQUEST)
                  ->rule('username', 'not_empty')
                  ->rule('username', 'min_length', array(':value', 1))
                  ->rule('username', 'max_length', array(':value', 127))
                  ->rule('password', 'not_empty');             
               if ($validation->check()) {
                  $validation->error('password', 'invalid');
               }
               $view->set('errors', $validation->errors('login'));  
            }
         }
         // allow setting the username as a get param
         if(isset($_GET['username'])) {
            $view->set('username', Security::xss_clean($_GET['username']));
         }
         $providers = Kohana::config('useradmin.providers');
         $view->set('facebook_enabled', isset($providers['facebook']) ? $providers['facebook'] : false);
         $this->template->content = $view;
      }
   }

   /**
    * Log the user out.
    */
   public function action_logout() {
      // Sign out the user
      Auth::instance()->logout();

      // redirect to the user account and then the signin page if logout worked as expected
      $this->request->redirect('user/profile');
   }

   /**
    * A basic implementation of the "Forgot password" functionality
    */
   public function action_forgot() {
      // Password reset must be enabled in config/useradmin.php
      if(!Kohana::config('useradmin')->email) {
         Message::add('error', 'Password reset via email is not enabled. Please contact the site administrator to reset your password.');
         $this->request->redirect('user/register');
      }
      // set the template title (see Controller_App for implementation)
      $this->template->title = __('Forgot password');
      if(isset($_POST['reset_email'])) {
         $user = ORM::factory('user')->where('email', '=', $_POST['reset_email'])->find();
         // admin passwords cannot be reset by email
         if (is_numeric($user->id) && ($user->username != 'admin')) {
            // send an email with the account reset token
            $user->reset_token = $user->generate_password(32);
            $user->save();

            $message = "You have requested a password reset. You can reset password to your account by visiting the page at:\n\n"
            .":reset_token_link\n\n"
            ."If the above link is not clickable, please visit the following page:\n"
            .":reset_link\n\n"
            ."and copy/paste the following Reset Token: :reset_token\nYour user account name is: :username\n";

            $mailer = Email::connect();
            // Create complex Swift_Message object stored in $message
            // MUST PASS ALL PARAMS AS REFS
            $subject = __('Account password reset');
            $to = $_POST['reset_email'];
            $from = Kohana::config('useradmin')->email_address;
            $body =  __($message, array(
                ':reset_token_link' => URL::site('user/reset?reset_token='.$user->reset_token.'&reset_email='.$_POST['reset_email'], TRUE),
                ':reset_link' => URL::site('user/reset', TRUE),
                ':reset_token' => $user->reset_token,
                ':username' => $user->username
            ));
            $message_swift = Swift_Message::newInstance($subject, $body)
                    ->setFrom($from)
                    ->setTo($to);
            if($mailer->send($message_swift)) {
               Message::add('success', __('Password reset email sent.'));
               $this->request->redirect('admin/user/login');
            } else {
               Message::add('failure', __('Could not send email.'));
            }
         } else if ($user->username == 'admin') {
            Message::add('error', __('Admin account password cannot be reset via email.'));
         } else {
            Message::add('error', __('User account could not be found.'));
         }
      }
     $this->template->content = View::factory('user/reset/forgot');
   }

   /**
    * A basic version of "reset password" functionality.
    */
  function action_reset() {
      // Password reset must be enabled in config/useradmin.php
      if(!Kohana::config('useradmin')->email) {
         Message::add('error', 'Password reset via email is not enabled. Please contact the site administrator to reset your password.');
         $this->request->redirect('user/register');
      }
      // set the template title (see Controller_App for implementation)
      $this->template->title = __('Reset password');
      if(isset($_REQUEST['reset_token']) && isset($_REQUEST['reset_email'])) {
         // make sure that the reset_token has exactly 32 characters (not doing that would allow resets with token length 0)
         if( (strlen($_REQUEST['reset_token']) == 32) && (strlen(trim($_REQUEST['reset_email'])) > 1) ) {
            $user = ORM::factory('user')->where('email', '=', $_REQUEST['reset_email'])->and_where('reset_token', '=', $_REQUEST['reset_token'])->find();
            // The admin password cannot be reset by email
            if ($user->username == 'admin') {
               Message::add('failure', __('The admin password cannot be reset by email.'));
            } else if (is_numeric($user->id) && ($user->reset_token == $_REQUEST['reset_token'])) {
               $password = $user->generate_password();
               $user->password = $password;
// This field does not exist in the default config:
//               $user->failed_login_count = 0;
               $user->save();
               Message::add('success', __('Password reset.'));
               Message::add('success', '<p>'.__('Your password has been reset to: ":password".', array(':password' => $password)).'</p><p>'.__('Please log in below.').'</p>');
               $this->request->redirect('user/login?username='.$user->username);
            }
        }
     }
     $this->template->content = View::factory('user/reset/reset');
  }

   /**
    * The after() method is called after your controller action.
    * In our template controller we override this method so that we can
    * make any last minute modifications to the template before anything
    * is rendered.
    */
   public function after() {
      if ($this->auto_render === TRUE) {         
         $styles = array( 'css/style.css' => 'screen');
         $scripts = array();

         $this->template->styles = array_merge( $this->template->styles, $styles );
         $this->template->scripts = array_merge( $this->template->scripts, $scripts );
         // Assign the template as the request response and render it
         $this->response->body( $this->template );
      }
      parent::after();
   }

}
