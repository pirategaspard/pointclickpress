<?php defined('SYSPATH') or die('No direct script access.');

class Model_Base_Action extends Model 
{
	protected $id = 0;		
	protected $action = '';
	protected $action_label = '';
	protected $action_value = '';
	
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
		if (isset($args['action']))
		{
			$this->action = $args['action'];
		}
		if (isset($args['action_label']))
		{
			$this->action_label = $args['action_label'];
		}
		if (isset($args['action_value']))
		{
			$this->action_value = $args['action_value'];
		}
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	id
							,action
							,action_label
							,action_value
					FROM actions e
					WHERE id = :id';
			$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)->execute()->as_array();											
							
			if (count($q_results) > 0 )
			{				
				$this->init($q_results[0]);	
			}
		}
		return $this;
	}
	
	
	function save()
	{	
		$results = new pcpresult();
		if ($this->id == 0)
		{
			//INSERT new record
			$q = '	INSERT INTO actions
						(action
						,action_label
						,action_value)
					VALUES (
						:action
						,:action_label
						,:action_value
						)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':action',$this->action)
								->param(':action_label',$this->action_label)
								->param(':action_value',$this->action_value)
								->execute();						
			if ($q_results[1] > 0)
			{
				$this->id = $q_results[0];
				$results->success = 1;
			}
			else
			{
				throw new Kohana_Exception('Error Inserting Record in file: :file',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		elseif ($this->id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE actions
						SET action = :action,
							action_label = :action_label,
							action_value = :action_value
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':action',$this->action)
								->param(':action_value',$this->action_value)
								->param(':action_label',$this->action_label)
								->param(':id',$this->id)
								->execute();																	
			}
			catch( Database_Exception $e )
			{
				throw new Kohana_Exception('Error Updating Record in file: :file',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function delete()
	{
		$results = new pcpresult();
		if ($this->id > 0)
		{
				
			$q = '	DELETE FROM actions
						WHERE id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':id',$this->id)
								->execute();						
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
}

?>
