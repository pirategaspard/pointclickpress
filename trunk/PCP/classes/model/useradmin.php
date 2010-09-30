<?php defined('SYSPATH') or die('No direct script access.');

class Model_Useradmin extends model 
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
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			
			$q = '	SELECT 	id
							,email
							,username							
							,active
							,logins
							,last_login
							,last_ip_address							
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
				$q = '	INSERT INTO users
						(email,username,password,active,logins,last_ip_address,created)
						VALUES
						(
							:email
							,:username
							,:password
							,:active
							,:logins
							,:last_ip_address
							,NOW()
						)';				
				$results = DB::query(Database::INSERT,$q,TRUE)
								->param(':email',$this->email)
								->param(':username',$this->username)
								->param(':password',$this->password)
								->param(':active',$this->active)
								->param(':logins',$this->logins)
								->param(':last_ip_address',$this->last_ip_address)
								->execute();	
								
				if ($results[1] > 0)
				{
					$this->id = $results[0];
					$results['id'] = $this->id;
					$results['success'] = $this->id;
				}
				else
				{
					echo('somethings wrong');
					var_dump($results);
				}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE users
						SET email = :email
							,username = :username
							,active = :active
						WHERE id = :id';
				$results['success'] = DB::query(Database::UPDATE,$q,TRUE)
								->param(':email',$this->email)
								->param(':username',$this->username)
								->param(':active',$this->active)
								->param(':id',$this->id)
								->execute();										
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
	
	function __set($prop, $value)
	{			
		$this->$prop = $value;
	}
	
}

?>