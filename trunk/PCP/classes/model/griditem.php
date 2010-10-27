<?php defined('SYSPATH') or die('No direct script access.');
class Model_GridItem extends Model_ItemDef 
{
	protected $itemdef_id = 0;
	protected $type = '';	
	protected $cell_id = NULL;	
	protected $scene_id = 0;
	
	public function __construct($args=array())
	{
		parent::__construct();		
		$this->init($args);		
	}
	
	function init($args=array())
	{	
		parent::init($args);
		if (isset($args['itemdef_id']))
		{
			$this->itemdef_id = $args['itemdef_id'];
		}	
		if (isset($args['type']))
		{
			$this->type = $args['type'];
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
		if (($this->id > 0)&&($this->scene_id > 0))
		{
			$q = '	SELECT 	id.id as itemdef_id	
							,id.title as type						
							,git.id
							,git.cell_id
							,git.scene_id
							,git.title							
					FROM itemdefs id
					INNER JOIN grids_items git
					ON id.id = git.itemdef_id
					WHERE git.id = :id';
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
		if (($this->id == 0))
		{
			//INSERT new record
			$q = '	INSERT INTO grids_items
						(itemdef_id
						,scene_id
						,cell_id
						,title
						,slug
						)
					VALUES (
						:itemdef_id
						,:scene_id
						,:cell_id
						,:title
						,:slug
						)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':scene_id',$this->scene_id)
								->param(':cell_id',$this->cell_id)
								->param(':title',$this->title)
								->param(':slug',$this->slug)
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
				$q = '	UPDATE grids_items
						SET itemdef_id = :itemdef_id
							,scene_id = :scene_id
							,cell_id = :cell_id
							,title = :title
							,slug = :slug
						WHERE id = :id';
				$results->success = DB::query(Database::UPDATE,$q,TRUE)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':scene_id',$this->scene_id)
								->param(':cell_id',$this->cell_id)
								->param(':title',$this->title)
								->param(':slug',$this->slug)
								->param(':id',$this->id)
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
		if ($this->id > 0)
		{
				
			$q = '	DELETE FROM grids_items
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
