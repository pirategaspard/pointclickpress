<?php defined('SYSPATH') or die('No direct script access.');
class Model_Item extends Model 
{
	protected $id = 0;
	protected $label = '';
	protected $story_id = 0;
	protected $image_id = 0;
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
		if (isset($args['label']))
		{
			$this->label = $args['label'];
		}
		if (isset($args['story_id']))
		{
			$this->story_id = $args['story_id'];
		}		
		if (isset($args['image_id']))
		{
			$this->image_id = $args['image_id'];
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
			$q = '	SELECT 	it.id
							,it.label
							,it.story_id
							,it.image_id
							,i.filename
					FROM items it
					LEFT OUTER JOIN images i
					ON it.image_id = i.id
					WHERE it.id = :id';
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
			$q = '	INSERT INTO items
						(label
						,story_id
						,image_id)
					VALUES (
						:label
						,:story_id
						,:image_id)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':label',$this->label)
								->param(':story_id',$this->story_id)
								->param(':image_id',$this->image_id)
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
				$q = '	UPDATE items
						SET label = :label,
							image_id = :image_id
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':label',$this->label)
								->param(':image_id',$this->image_id)
								->param(':id',$this->id)
								->execute();																	
			}
			catch( Database_Exception $e )
			{
				var_dump($e); die();
				throw new Kohana_Exception('Error Updating Record in file: :file - ',
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
				
			$q = '	DELETE FROM items
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
