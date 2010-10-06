<?php defined('SYSPATH') or die('No direct script access.');

class Model_Image extends Model 
{
	protected $id = 0;
	protected $story_id = 0;		
	protected $filename = '';

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
		if ((isset($args['story_id']))&&(is_numeric($args['story_id'])))
		{
			$this->story_id = $args['story_id'];
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
		$results = new pcpresult();
		if ($this->id == 0)
		{
			try
			{
				//INSERT new record
				$q = '	INSERT INTO images
							(story_id,filename)
						VALUES (:story_id,:filename)';
							
				$q_results = DB::query(Database::INSERT,$q,TRUE)							
									->param(':story_id',$this->story_id)
									->param(':filename',$this->filename)
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
			catch( Database_Exception $e )
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
				$q = '	UPDATE images
							SET story_id = :story_id
								,filename = :filename
						WHERE id = :id';
							
				$results->success = DB::query(Database::INSERT,$q,TRUE)							
									->param(':id',$this->id)
									->param(':story_id',$this->story_id)
									->param(':filename',$this->filename)
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
			$q = '	DELETE FROM images
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
