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
					SELECT DISTICT
						 :itemdef_id AS itemdef_id
						 ,:id AS id
					FROM itemdefs
					WHERE EXISTS 
							(
								SELECT s.id 
								FROM itemdefs i
								INNER JOIN stories s 
									ON i.story_id = s.id
									AND s.creator_user_id = :creator_user_id
								WHERE i.id = :itemdef_id
							)';						
			$q_results = DB::query(Database::INSERT,$q,TRUE)
								->param(':itemdef_id',$this->itemdef_id)
								->param(':id',$this->id)
								->param(':creator_user_id',Auth::instance()->get_user()->id)
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
			$q = '	DELETE ida 
					FROM items_defs_actions ida
					INNER JOIN itemdefs i
						ON ida.itemdef_id = i.id
					INNER JOIN stories s 
						ON i.story_id = s.id
						AND s.creator_user_id = :creator_user_id
					WHERE ida.action_id = :id';
			$results->success =	DB::query(Database::DELETE,$q,TRUE)
									->param(':id',$this->id)
									->param(':creator_user_id',Auth::instance()->get_user()->id)
									->execute();									
			if ($results->success)
			{
				parent::delete();
			}
		}		
		return $results;
	}
}

?>
