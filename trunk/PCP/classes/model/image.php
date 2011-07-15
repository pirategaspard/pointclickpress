<?php defined('SYSPATH') or die('No direct script access.');

class Model_Image extends Model 
{
	protected $id = 0;
	protected $story_id = 0;
	protected $type_id = 1;		
	protected $filename = '';

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
		if ((isset($args['story_id']))&&(is_numeric($args['story_id'])))
		{
			$this->story_id = $args['story_id'];
		}
		if ((isset($args['type_id']))&&(is_numeric($args['type_id'])))
		{
			$this->type_id = $args['type_id'];
		}
		if (isset($args['filename']))
		{
			$this->filename = $args['filename'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	i.id
							,story_id
							,type_id													
							,i.filename							
					FROM images i
					WHERE i.id = :id';
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
				$q = '	INSERT INTO images
							(story_id,type_id,filename)
						SELECT DISTINCT
							:story_id AS story_id
							,:type_id AS type_id
							,:filename AS filename
						FROM stories
						WHERE EXISTS 
								(
									SELECT s.id 
									FROM stories s 
									WHERE s.id = :story_id 
									AND s.creator_user_id = :creator_user_id
								)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)							
									->param(':story_id',$this->story_id)
									->param(':type_id',$this->type_id)
									->param(':filename',$this->filename)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();			
				if ($q_results[1] > 0)
				{
					$this->id = $q_results[0];
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Image Saved";
				}
			}
			elseif ($this->id > 0)
			{
			//UPDATE record	
				$q = '	UPDATE images i
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						SET i.story_id = :story_id
							,i.filename = :filename
						WHERE i.id = :id';
							
				$records_updated = DB::query(Database::INSERT,$q,TRUE)							
									->param(':id',$this->id)
									->param(':story_id',$this->story_id)
									->param(':filename',$this->filename)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();	
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Image Saved";
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
				$q = '	DELETE i 
						FROM images i
						INNER JOIN stories s 
							ON i.story_id = s.id
							AND s.creator_user_id = :creator_user_id
						WHERE i.id = :id';
				$records_updated =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();
				if ($records_updated > 0)
				{
					$result->success = PCPRESULT_STATUS_SUCCESS;
					$result->message = "Image Deleted";
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
