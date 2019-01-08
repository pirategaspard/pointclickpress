<?php
class model_Utils_ModuleHelper
{
	static function searchDirectoryForModules($dir='')
	{	
		$path = APPPATH.$dir;
		$modules = array();
		if (is_dir($path))
		{
			$f = scandir($path);		
			foreach($f as $file)
			{
				//if a file is actually a directory 
				if ((is_dir($path.'/'.$file))&&(substr($file,0,1) != '.')&&(substr($file,0,1) != '~'))
				{	
					// ...and it has a file inside classes subdir that is named the same as dir
					if (file_exists($path.'/'.$file.'/classes/'.$dir.'/'.$file.'.php'))
					{
						// ...we call it a module and add it to the list
						$modules[] = $dir.DIRECTORY_SEPARATOR.$file;
					}					
				}
			}						
		}
		return $modules;	
	}

	static function addModulePath($dir)
	{	
		$m = Kohana::modules();		
		$m[$dir] = $dir.DIRECTORY_SEPARATOR;			
		Kohana::modules($m);
	}
	
	static function removeModulePath($dir)
	{		
		$m = Kohana::modules();		
		unset($m[$dir]);		
		Kohana::modules($m);
	}
		
	static function saveModule($dir)
	{	
		if(count(self::getModuleByDir($dir)) == 0)
		{
			$q = '	INSERT INTO modules
				(dir)
				VALUES
				(
					:dir
				)';
		$q_results = DB::query(Database::INSERT,$q,TRUE)
											->param(':dir',$dir)
											->execute();
		}
	}
	
	static function getModuleByDir($dir) 
	{
		$q = '	SELECT dir
				FROM modules
				WHERE dir = :dir';
		return DB::query(Database::SELECT,$q,TRUE)->param(':dir',$dir)->execute()->as_array();
	}	
	
	static function getModules() 
	{
		$modules = array();
		$q = '	SELECT dir
				FROM modules';
		return DB::query(Database::SELECT,$q,TRUE)->execute()->as_array();
	}
	
	static function loadModules() 
	{
		$modules = self::getModules();
		foreach ($modules as $module)
		{
			// add matching paths to Kohana's module paths	
			self::addModulePath($module['dir']);
		}
	}
}
?>
