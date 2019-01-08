<?php defined('SYSPATH') or die('No direct script access.');

/*
 * StoryPlugin object 
 * */

class Model_Admin_Plugin extends Model 
{
	protected $id = 0;	
	protected $status = 0;
	protected $label = '';
	protected $description = '';
	
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
		if (isset($args['story_id']))
		{			
			$this->story_id = $args['story_id'];					
		}
		if (isset($args['plugin_id']))
		{
			$this->plugin_id = $args['plugin_id'];
		}
		if (isset($args['status']))
		{
			$this->status = $args['status'];
		}
		if (isset($args['label']))
		{
			$this->label = $args['label'];
		}
		if (isset($args['description']))
		{
			$this->description = $args['description'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	sp.id
							,sp.story_id
							,sp.plugin_id
							,sp.status
							,p.status
					FROM stories_plugins sp
					INNER JOIN plugins p
						ON sp.plugin_id = p.plugin_id
					WHERE sp.id = :id';
			$result = DB::query(Database::SELECT,$q,TRUE)->param(':id',$this->id)
															->execute()
															->as_array();				
			if (count($result) > 0 )
			{
				$this->init($result[0]);				
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
				$q = '	INSERT INTO stories_plugins
							(story_id
							,plugin_id
							,status)
						VALUES (
							:story_id
							,:plugin_id
							,status)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)
									->param(':story_id',$this->story_id)
									->param(':plugin_id',$this->plugin_id)
									->param(':status',$this->status)
									->execute();			
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Plugin Saved";
				}
			}
			elseif ($this->id > 0)
			{
				//UPDATE record
				$q = '	UPDATE stories_plugins
						SET status = :status							
						WHERE id = :id';
				$records_updated = DB::query(Database::UPDATE,$q,TRUE)
										->param(':status',$this->status)
										->param(':id',$this->id)
										->execute();	
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Plugin Updated";
				}																
			}
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Saving Record';
			Kohana::$log->add(Log::ERROR, $e->getMessage().' in file'.__FILE__);	
		}
		$result->data = array('id'=>$this->id);
		return $result;
	}
	
	function delete()
	{	
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");	
		$result->data = array('id'=>$this->id);
		try
		{
			if ($this->id > 0)
			{
				$q = '	DELETE FROM stories_plugins
							WHERE id = :id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Plugin Deleted";
				}						
			}		
		}
		catch( Database_Exception $e )
		{
			$result->success = PCPRESULT_STATUS_FAILURE;
			$result->message = 'Error Saving Record';
			Kohana::$log->add(Log::ERROR, $e->getMessage().' in file'.__FILE__);	
		}
		return $result;
	}
}

?>
