<?php defined('SYSPATH') or die('No direct script access.');

class Model_Base_PCPAction extends Model 
{
	protected $id = 0;		
	protected $action = '';
	protected $action_label = '';
	protected $action_value = '';
	
	public function __construct($args=array())
	{		
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
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		try
		{
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
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Action Saved";
				}
			}
			elseif ($this->id > 0)
			{
				//UPDATE record
				$q = '	UPDATE actions
						SET action = :action,
							action_label = :action_label,
							action_value = :action_value
						WHERE id = :id';
				$records_updated = DB::query(Database::UPDATE,$q,TRUE)
								->param(':action',$this->action)
								->param(':action_value',$this->action_value)
								->param(':action_label',$this->action_label)
								->param(':id',$this->id)
								->execute();																	
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Action Saved";
				}															
			}			
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Saving Record';
			Kohana::$log->add(Log::ERROR, $e->getmessage().' in file'.__FILE__);
		}
		$result->data = array('id'=>$this->id);
		return $result;
	}
	
	function delete()
	{
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		try
		{
			if ($this->id > 0)
			{
					
				$q = '	DELETE FROM actions
							WHERE id = :id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->execute();						
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Action Deleted";
				}								
			}		
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Deleting Record';
			Kohana::$log->add(Log::ERROR, $e->getmessage().' in file'.__FILE__);				
		}
		$result->data = array('id'=>$this->id);
		return $result;
	}
}

?>
