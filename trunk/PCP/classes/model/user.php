<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends model 
{
	protected $id = 0;
	protected $username = "";
	protected $password = "";
	protected $email = "";
	protected $logins = 0;
	protected $admin = 0;
	protected $active = 0;
	protected $moderator = 0;
	protected $last_ip_address = "";
	protected $last_login = "";
	protected $created = "";
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{
		if ((isset($args['id']))&&(is_numeric($args['id'])))
		{
			$this->id = $args['id'];
		}
		if (isset($args['email']))
		{			
			$this->email = $args['email'];					
		}
		if (isset($args['username']))
		{
			$this->username = $args['username'];
		}
		if (isset($args['password']))
		{
			$this->password = $args['password'];
		}
		if (isset($args['logins']))
		{
			$this->logins = $args['logins'];
		}
		if (isset($args['active']))
		{
			$this->active = $args['active'];
		}
		if (isset($args['admin']))
		{
			$this->admin = $args['admin'];
		}
		if (isset($args['moderator']))
		{
			$this->moderator = $args['moderator'];
		}
		if (isset($args['last_ip_address']))
		{
			$this->last_ip_address = $args['last_ip_address'];
		}
		if (isset($args['last_login']))
		{
			$this->last_login = $args['last_login'];
		}
		if (isset($args['created']))
		{
			$this->created = $args['created'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			
			$q = '	SELECT 	id
							,email
							,username
							,logins
							,active
							,admin
							,moderator
							,last_ip_address
							,last_login
							,created
					FROM users
					WHERE id = :id';
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();				
							
			if (count($results) > 0 )
			{
				$this->init($results[0]);				
			}
		}
		return $this;
	}	
	
	function save()
	{	
		$results['id'] = $this->id;	
		$results['success'] = 0;
		
		if ($this->id == 0)
		{
			// cannot create user from here
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				;										
			}
			catch( Database_Exception $e )
			{
				echo('somethings wrong');
				echo $e->getMessage(); die();
			}
		}
		return $results;
	}
	
	function delete()
	{	
		if ($this->id > 0)
		{
			$q = '	DELETE FROM users
						WHERE id = :id';
			$results =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}
		return 1;
	}	
	
	function __get($prop)
	{			
		return $this->$prop;
	}
	
}

?>