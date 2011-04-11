<?php defined('SYSPATH') or die('No direct script access.');

class Model_Plugins
{
	static function getPlugin($args=array())
	{
		if (isset($args['plugin']))
		{
			$p = self::getByClassName($args['plugin']);
		}
		else if (isset($args['id']))
		{
			$p = self::getByID($args['id']);
		}
		else
		{
			$p = array();
		}
		return $p;
	}
	
	static function getByID($id) 
	{
		$q = '	SELECT *
				FROM plugins
				WHERE id = :id';
		return DB::query(Database::SELECT,$q,TRUE)->param(':id',$id)->execute()->as_array();
	}
	
	static function getByClassName($class_name)
	{
		$q = '	SELECT *
				FROM plugins
				WHERE class = :class';
		return DB::query(Database::SELECT,$q,TRUE)
										->param(':class',$class_name)										
										->execute()
										->as_array();	
	}
}
?>
