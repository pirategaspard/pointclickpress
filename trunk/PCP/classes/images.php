<?php defined('SYSPATH') or die('No direct script access.');

class Images
{	
	static function getImage($args=array())
	{
		// get a single story object and populate it based on the arguments
		$story = new Model_Image($args);
		$story->load($args);
		return $story;		
	}

	static function getImages($args=array())
	{				
		// get all the Images in the db
		$q = '	SELECT i.*
				FROM Images i
				WHERE 1 = 1 ';
				
		if (isset($args['image'])) $q .= 'AND i.id = :image_id'; //if we have a id
		
		$q .= ' ORDER BY i.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['image']))	 $q->param(':image_id',$args['image']->id);
								
		$tempArray = $q->execute()->as_array();		
		
		$Images = array();
		foreach($tempArray as $a)
		{
			$Images[$a['id']] = Images::getImage()->init($a);
		}
		return $Images;		
	}
}
