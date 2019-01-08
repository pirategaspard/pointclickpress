<?php defined('SYSPATH') or die('No direct script access.');

/* 
 * 
 * */

class Model_Admin_StorypluginsAdmin extends Model
{
	static function getStoryplugin($args=array())
	{
		$sp = new Model_Admin_Storyplugin($args);
		return $sp->load($args);
	}
	
	static function getStoryplugins($args=array())
	{
		$q = '	SELECT 	p.label
						,p.description
						,p.id AS plugin_id
						,p.class as class_name
						,IFNULL(sp.storyplugin_id,0) AS storyplugin_id
						,CASE
							WHEN p.status = 0 THEN 0
							WHEN p.status = 1 AND IFNULL(sp.status,0) = 1 THEN 1
							ELSE 0
						END as status						
				FROM plugins p 
				LEFT OUTER JOIN stories_plugins sp
					ON p.id = sp.plugin_id
					AND sp.story_id = :story_id 
				WHERE p.system = 0 
				ORDER BY p.class ASC';
		
		$q = DB::query(Database::SELECT,$q,TRUE)->param(':story_id',$args['story_id']);
								
		$tempArray = $q->execute()->as_array();
		
		$storyplugins = array();
		foreach($tempArray as $a)
		{			
			$storyplugins[] = self::getStoryplugin()->init($a);
		}
		return $storyplugins;		
	}
	
	static function getData()
	{
		$session = Session::instance('admin');
		$data = $_POST;	
		if (isset($_REQUEST['id']))
		{
			$data['id'] = $_REQUEST['id'];		
		}
		if (isset($_REQUEST['storyplugin_id']))
		{
			$data['storyplugin_id'] = $_REQUEST['storyplugin_id'];		
		}
		if (isset($_REQUEST['story_id']))
		{
			$data['story_id'] = $_REQUEST['story_id'];		
		}
		else if ($session->get('story_id'))
		{
			$data['story_id'] = $session->get('story_id');
		}
		if (isset($_REQUEST['plugin_id']))
		{
			$data['plugin_id'] = $_REQUEST['plugin_id'];	
		}
		if (isset($_REQUEST['status']))
		{
			$data['status'] = $_REQUEST['status'];	
		}
		$data['user_id'] = $data['creator_user_id'] = Auth::instance()->get_user()->id;
		return $data;
	}
}
?>
