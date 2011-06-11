<?php defined('SYSPATH') or die('No direct script access.');

class Model_ItemdefAction extends Model_Base_PCPAction 
{	
	protected $itemdef_id = 0;
	
	public function __construct($args=array())
	{		
		$this->init($args);		
	}
	
	function init($args=array())
	{		
		parent::init($args);
		if ((isset($args['itemdef_id']))&&(is_numeric($args['itemdef_id'])))
		{
			$this->itemdef_id = $args['itemdef_id'];
		}
		return $this;
	}
	
	function load($args=array())
	{
		
		if ($this->id > 0)
		{
			$q = '	SELECT 	e.id
							,e.action
							,e.action_label
							,e.action_value
							,ce.itemdef_id
					FROM actions e
					INNER JOIN items_defs_actions ce
					ON e.id = ce.action_id
					WHERE e.id = :id';
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
			parent::save();
			//INSERT new record
			$q = '	INSERT INTO items_defs_actions
						(itemdef_id,action_id)
					VALUES (:itemdef_id,:id)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':id',$this->id)
								->execute();			
			if ($q_results[1] > 0)
			{
				$this->id = $q_results[0];
				$results->success = 1;
			}
			else
			{
				Kohana::$log->add(Log::ERROR, 'Error Updating Record in file'.__FILE__);
				throw new Kohana_Exception('Error Updating Record in file: :file',
					array(':file' => __FILE__));
			}
		}
		elseif ($this->id > 0)
		{
			$results = parent::save();														
		}
		$results->data = array('id'=>$this->id);
		return $results;
	}
	
	function delete()
	{
		$results = new pcpresult();
		$results->data = array('id'=>$this->id);
		if ($this->id > 0)
		{
			$q = '	DELETE FROM items_defs_actions
						WHERE action_id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->execute();									
			parent::delete();
		}		
		return $results;
	}
}

?>
