<?php defined('SYSPATH') or die('No direct script access.');
class Model_GridItem extends Model_item 
{
	protected $grid_item_id = 0;
	protected $scene_id = 0;
	protected $cell_id = '';	
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{	
		parent::init($args);
		if (isset($args['grid_item_id']))
		{
			$this->grid_item_id = $args['grid_item_id'];
		}	
		if (isset($args['scene_id']))
		{
			$this->scene_id = $args['scene_id'];
		}
		if (isset($args['cell_id']))
		{
			$this->cell_id = $args['cell_id'];
		}
		return $this;
	}
	
	function load($args=array())
	{		
		if (($this->grid_item_id > 0)&&($this->scene_id > 0))
		{
			$q = '	SELECT 	it.id	
							,it.title						
							,it.image_id
							,i.filename
							,git.grid_item_id
							,git.cell_id
							,git.scene_id							
					FROM items it
					LEFT OUTER JOIN images i
					ON it.image_id = i.id
					LEFT OUTER JOIN grids_items git
					ON it.id = git.item_id
					WHERE git.grid_item_id = :grid_item_id';
			$q_results = DB::query(Database::SELECT,$q,TRUE)->param(':grid_item_id',$this->grid_item_id)->execute()->as_array();											
							
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
		if (($this->grid_item_id == 0))
		{
			//INSERT new record
			$q = '	INSERT INTO grids_items
						(item_id
						,scene_id
						,cell_id)
					VALUES (
						:item_id
						,:scene_id
						,:cell_id
						)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':item_id',$this->id)
								->param(':scene_id',$this->scene_id)
								->param(':cell_id',$this->cell_id)
								->execute();									
			if ($q_results[1] > 0)
			{
				$this->grid_item_id = $q_results[0];
				$results->success = 1;
			}
			else
			{
				throw new Kohana_Exception('Error Inserting Record in file: :file',
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		elseif ($this->grid_item_id > 0)
		{
			//UPDATE record
			try
			{
				$q = '	UPDATE grids_items
						SET scene_id = :scene_id,
							cell_id = :cell_id
						WHERE grid_item_id = :grid_item_id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':scene_id',$this->scene_id)
								->param(':cell_id',$this->cell_id)
								->param(':grid_item_id',$this->grid_item_id)
								->execute();																	
			}
			catch( Database_Exception $e )
			{				
				throw new Kohana_Exception('Error Updating Record in file: :file '.$e->getMessage(),
					array(':file' => Kohana::debug_path(__FILE__)));
			}
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function delete()
	{
		$results = new pcpresult();
		if ($this->grid_item_id > 0)
		{
				
			$q = '	DELETE FROM grids_items
						WHERE grid_item_id = :grid_item_id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
								->param(':grid_item_id',$this->grid_item_id)
								->execute();						
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
}

?>
