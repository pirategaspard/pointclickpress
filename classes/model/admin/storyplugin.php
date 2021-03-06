<?php defined('SYSPATH') or die('No direct script access.');

/*
 * StoryPlugin object 
 * */

class Model_Admin_StoryPlugin extends Model 
{
	protected $storyplugin_id = 0;	
	protected $story_id = 0;
	protected $plugin_id = 0;
	protected $status = 0;
	protected $label = '';
	protected $description = '';
	protected $class_name = '';
	
	public function __construct($args=array())
	{
		$this->init($args);		
	}
	
	function init($args=array())
	{	
		if ((isset($args['storyplugin_id']))&&(is_numeric($args['storyplugin_id'])))
		{
			$this->storyplugin_id = $args['storyplugin_id'];
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
		if (isset($args['class_name']))
		{
			$this->class_name = $args['class_name'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->storyplugin_id > 0)
		{
			$q = '	SELECT 	sp.storyplugin_id
							,sp.story_id
							,sp.plugin_id
							,sp.status
							,p.class as class_name
					FROM stories_plugins sp
					INNER JOIN plugins p
						ON sp.plugin_id = p.id
					WHERE sp.storyplugin_id = :storyplugin_id';
			$result = DB::query(Database::SELECT,$q,TRUE)->param(':storyplugin_id',$this->storyplugin_id)
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
			if ($this->storyplugin_id == 0)
			{
					//INSERT new record
					$q = '	INSERT INTO stories_plugins
								(story_id
								,plugin_id
								,status)
							VALUES (
								:story_id
								,:plugin_id
								,:status)';
								
					$q_results = DB::query(Database::INSERT,$q,TRUE)
										->param(':story_id',$this->story_id)
										->param(':plugin_id',$this->plugin_id)
										->param(':status',$this->status)
										->execute();			
					if ($q_results[1] > 0)
					{
						$this->storyplugin_id = $q_results[0];
						$result->success = PCPRESULT_STATUS_SUCCESS;
						$result->message = "Plugin Updated";
					}
			}
			elseif ($this->storyplugin_id > 0)
			{
					//UPDATE record
					$q = '	UPDATE stories_plugins
							SET status = :status							
							WHERE storyplugin_id = :storyplugin_id';
					$records_updated = DB::query(Database::UPDATE,$q,TRUE)
											->param(':status',$this->status)
											->param(':storyplugin_id',$this->storyplugin_id)
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
		$result->data = array('storyplugin_id'=>$this->storyplugin_id);
		return $result;
	}
	
	function delete()
	{	
		$result = new pcpresult(PCPRESULT_STATUS_INFO,"Nothing was changed");
		$result->data = array('storyplugin_id'=>$this->storyplugin_id);
		try
		{
			if ($this->storyplugin_id > 0)
			{
				$q = '	DELETE FROM stories_plugins
						WHERE storyplugin_id = :storyplugin_id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
										->param(':storyplugin_id',$this->storyplugin_id)
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
