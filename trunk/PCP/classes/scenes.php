<?php defined('SYSPATH') or die('No direct script access.');

class Scenes 
{
									 
	static function getScene($args=array())
	{
		// get a Scene_image object and populate it based on the arguments
		$Scene = new Model_Scene($args);		
		return $Scene->load($args);
	}
	
	static function getScenes($args=array())
	{				
		/*
			$args['container'] - story object		   
		*/		
		
		// get all the scenes in the db
		
		$q = '	SELECT sc.*
				FROM scenes sc
				INNER JOIN scene_containers c
				ON c.id = sc.container_id
				INNER JOIN stories s
				ON s.id = c.story_id
				WHERE 1 = 1 ';
				
		if (isset($args['scene'])) $q .= 'AND sc.id = :scene'; //if we have a scene id
		if (isset($args['container'])) $q .= 'AND c.id = :container'; //if we have a container id
		if (isset($args['story'])) $q .= 'AND s.id = :story'; //if we have a story id
		
		$q .= ' ORDER BY sc.id DESC';
		
		$q = DB::query(Database::SELECT,$q,TRUE);
		
		if (isset($args['scene']))	 $q->param(':scene',$args['scene']->id);
		if (isset($args['container']))	 $q->param(':container',$args['container']->id);
		if (isset($args['story']))	 $q->param(':story',$args['story']->id);
								
		$tempArray = $q->execute()->as_array();
		
		$Scenes = array();
		foreach($tempArray as $a)
		{
			if(isset($args['include_actions'])) $a['include_actions'] = $args['include_actions'];			
			$Scenes[$a['id']] = Scenes::getScene()->init($a);
		}
		return $Scenes;		
	}
	
	/* get a scene by container ID and value */
	static function getSceneByContainerId($container_id,$value='')
	{	
		$scene = Scenes::getScene(); // get empty scene object
		$q = '	SELECT 	s.id
						,s.story_id
						,s.container_id
						,s.title
						,s.description
						,s.filename
						,s.value
						,s.init_vars
					FROM scenes s
					INNER JOIN scene_containers c
					ON c.id = s.container_id
					AND c.id = :container_id
					WHERE value = :value';
		$results = DB::query(Database::SELECT,$q,TRUE)
								->param(':container_id',$container_id)
								->param(':value',$value)
								->execute()
								->as_array();
		if (count($results) > 0)			
		{
			$scene->init($results[0]); // populate scene object
		}
		return $scene;
	}
	
	static function uploadScene($args=array())
	{
		// Create the Upload and Media directories if they do not exist
		dir::prep_directory(UPLOADPATH);
		dir::prep_directory(MEDIAPATH);
		
		//is our image file valid?
		$valid = Validate::factory($_FILES)->rules('filename',array(
													'upload::valid'=>NULL, 
													'upload::not_empty'=>array(), 
													'upload::type'=>array(array('gif','jpg','jpeg','png')), 
													'upload::size'=>array('1M')));

		if ($valid->Check())
		{		
			
			// make a folders named story_id with a folder named container_id inside it
			// final path will be: /media/story_id/container_id/screen_type/WxH/filename
			$media_path = APPPATH.MEDIAPATH.$_POST['story_id'].DIRECTORY_SEPARATOR;
			dir::prep_directory($media_path);
			$media_path = $media_path.$_POST['container_id'].DIRECTORY_SEPARATOR;
			dir::prep_directory($media_path);
			$media_path = $media_path.$_POST['id'].DIRECTORY_SEPARATOR;
			dir::prep_directory($media_path);
			
			// upload original file from form 
			$temp_file = upload::save($_FILES['filename'],$_FILES['filename']['name'],APPPATH.UPLOADPATH);
			
			$filename = $_FILES['filename']['name'];  				
			
			//create directory for default image
			dir::prep_directory($media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR);
			//create default image and save it			
			$success = Image::factory($temp_file)
			->resize(800, 600, Image::WIDTH)
			->save($media_path.DIRECTORY_SEPARATOR.'default'.DIRECTORY_SEPARATOR.$filename);		
			
			//get array of Supported screens
			$SCREENS = pcp::getScreens();		
			// for each supported screen create image and save 	
			foreach($SCREENS as $screen)
			{
				//create directory to put image
				dir::prep_directory($media_path.DIRECTORY_SEPARATOR.$screen['w'].'x'.$screen['h'].DIRECTORY_SEPARATOR);
				
				$success = Image::factory($temp_file)
				->resize($screen['w'], $screen['h'], Image::WIDTH)
				->save($media_path.DIRECTORY_SEPARATOR.$screen['w'].'x'.$screen['h'].DIRECTORY_SEPARATOR.$filename);
			}
			
			/*
			//generate an image to support each of the screens 			
			foreach($SCREENS as $key=>$type)
			{
				// create directory for screen type
				dir::prep_directory($media_path.$key.DIRECTORY_SEPARATOR);
				foreach($type as $screen)
				{
					//create directory to put image
					dir::prep_directory($media_path.$key.DIRECTORY_SEPARATOR.$screen['width'].'x'.$screen['height'].DIRECTORY_SEPARATOR);
					
					$success = Image::factory($temp_file)
					->resize($screen['width'], $screen['height'], Image::WIDTH)
					->save($media_path.$key.DIRECTORY_SEPARATOR.$screen['width'].'x'.$screen['height'].DIRECTORY_SEPARATOR.$filename);
				}
			}*/
			
			$results = array('success'=>$success,'filename'=>$filename,'path'=>UPLOADPATH);
		}
		else
		{
			$results = array_merge(array('success'=>false),$valid->errors());
		}
		return $results;
	}
}
