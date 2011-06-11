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
			$results = DB::query(Database::SELECT,$q,TRUE)->param(':storyplugin_id',$this->storyplugin_id)
															->execute()
															->as_array();				
			if (count($results) > 0 )
			{
				$this->init($results[0]);				
			}
		}
		return $this;
	}	
	
	function save()
	{	
		$results = new pcpresult();	
		if ($this->storyplugin_id == 0)
		{
			//INSERT new record
			try
			{
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
					$results->success = 1;
				}
			}
			catch( Database_Exception $e )
			{
				Kohana::$log->add(Log::ERROR, 'Error Inserting Record in file'.__FILE__);
				throw new Kohana_Exception('Error Inserting Record in file: :file '.$e->getMessage(),
					array(':file' => __FILE__));
			}
		}
		elseif ($this->storyplugin_id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE stories_plugins
						SET status = :status							
						WHERE storyplugin_id = :storyplugin_id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
										->param(':status',$this->status)
										->param(':storyplugin_id',$this->storyplugin_id)
										->execute();														
			}
			catch( Database_Exception $e )
			{
				Kohana::$log->add(Log::ERROR, 'Error Updating Record in file'.__FILE__);
				throw new Kohana_Exception('Error Updating Record in file: :file '.$e->getMessage(),
					array(':file' =>__FILE__));
			}
		}
		$results->data = array('storyplugin_id'=>$this->storyplugin_id);
		return $results;
	}
	
	function delete()
	{	
		$results = new pcpresult();
		$results->data = array('storyplugin_id'=>$this->storyplugin_id);
		if ($this->storyplugin_id > 0)
		{
			$q = '	DELETE FROM stories_plugins
						WHERE storyplugin_id = :storyplugin_id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':storyplugin_id',$this->storyplugin_id)
								->execute();						
		}		
		return $results;
	}
}

?>
