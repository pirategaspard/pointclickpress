<?php defined('SYSPATH') or die('No direct script access.');

class Usersadmin
{
	public static function getUser($args=array())
	{
		$user = new Model_Useradmin($args);		
		return $user->load($args);
	}
	
	public static function getUsers($args=array())
	{				
		// get all the scenes in the db		
		$q = '	SELECT 	id					
				FROM users';				
		$tempArray = DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();		
		$users = array();
		foreach($tempArray as $a)
		{		
			$users[$a['id']] = UsersAdmin::getUser($a);
		}
		return $users;		
	}
	
	/* 
		returns 0 on failure, id of user record on success
	 */
	public static function authenticate($username = '', $password = '')
	{		
		$results['id'] = 0;
		$results['success'] = 0;
		if ((!empty($password)) && (is_string($password)) && (is_string($username))) 
		{
			$q = '	SELECT id
					FROM users
					WHERE active = 1
					AND username = :username
					AND password = :password';
			$result = DB::query(Database::SELECT,$q,TRUE)
								->param(':username',$username)
								->param(':password',UsersAdmin::hash($password))
								->execute()
								->as_array();
			// if we have 1 and only one record then we are good
			if (count($result) == 1)
			{				
				$results['id'] = $result[0]['id'];
				$results['success'] = 1;
			}			
		}
		return $results;
	}
	
	public static function login($id = 0)
	{	
		$session_key = 'user_id';
		$loggedin = FALSE; 
		$session = Session::instance();
		$user = UsersAdmin::getUser(array('id'=>$id));		
		if (($user->id > 0) && ($session))
		{
			$user->logins += 1;	
			$user->last_login = time();
			$user->last_ip_address = $_SERVER['REMOTE_ADDR'];
			$user->save();
			$session->regenerate();
			$session->set($session_key, $user->id);
			$loggedin = TRUE;
		}
		return $loggedin;
	}
	
	public static function logout($id = 0)
	{
		$results = FALSE;
		if (UsersAdmin::isloggedin($id))
		{
			Session::instance()->destroy();		
			$results = TRUE;
		}
		return $results;
	}
	
	public static function isloggedin()
	{		
		$session_key = 'user_id';
		$results = FALSE;
		$session = Session::instance();
		$id = $session->get($session_key,0);
		if ($id > 0)
		{
			$results = TRUE;
		}
		return $results;
	}
	
	public static function create($args=array())
	{
		$results = FALSE;
		if ((!empty($args)) 
				&& (isset($args['username']))
				&& (isset($args['password'])) 
				&& (isset($args['password2'])) 
				&& (isset($args['email']))
				&& (strcmp($args['password'],$args['password2']) == 0)
				) 
		{
			if (!UsersAdmin::exists($args['username']))
			{

				$user = UsersAdmin::getUser()->init($args);
				$user->email = $args['email'];	
				$user->username = $args['username'];	
				$user->password = UsersAdmin::hash($args['password']);
				$user->logins = 0;	
				$user->created = time();
				$user->last_ip_address = $_SERVER['REMOTE_ADDR'];				
				
				$results = $user->save();
			} 
		}
		return $results; 
	}
	
	public static function exists($username='')
	{					
		$results = FALSE;
		$q = '	SELECT 	id					
				FROM users
				WHERE username = :username';				
		$tempArray = DB::query(Database::SELECT,$q,TRUE)
								->param(':username',$username)
								->execute()
								->as_array();
		if (count($tempArray) > 0)
		{
			$results = TRUE;
		}
		return $results;		
	}
	
	
	private static function hash($str='')
	{
		$method = 'sha1';
		$salt_pre = 'a1B2c3';
		$salt_post = 'X7y8Z9';		
		return hash($method, $salt_pre.$str.$salt_post); 
	} 
	
}
