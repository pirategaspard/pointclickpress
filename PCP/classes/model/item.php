<?php defined('SYSPATH') or die('No direct script access.');
class Model_Item extends Model 
{
	protected $id = 0;
	protected $label = '';
	protected $scene_id = 0;		
	protected $image_id = 0;
	protected $filename = '';
	protected $cell_id = '';
	
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
		if (isset($args['scene_id']))
		{
			$this->scene_id = $args['scene_id'];
		}
		if (isset($args['image_id']))
		{
			$this->image_id = $args['image_id'];
		}
		if (isset($args['filename']))
		{
			$this->filename = $args['filename'];
		}
		if (isset($args['cell_id']))
		{
			$this->cell_id = $args['cell_id'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if ($this->id > 0)
		{
			$q = '	SELECT 	it.id
							,it.scene_id
							,it.image_id
							,it.cell_id
							,i.filename
					FROM items it
					INNER JOIN images i
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
						(scene_id
						,image_id
						,cell_id)
					VALUES (
						:scene_id
						,:image_id
						,:cell_id
						)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':scene_id',$this->scene_id)
								->param(':image_id',$this->image_id)
								->param(':cell_id',$this->cell_id)
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
						SET scene_id = :scene_id,
							image_id = :image_id,
							cell_id = :cell_id
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':scene_id',$this->scene_id)
								->param(':image_id',$this->image_id)
								->param(':cell_id',$this->cell_id)
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
