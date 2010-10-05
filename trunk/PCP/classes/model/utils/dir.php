<?php defined('SYSPATH') or die('No direct script access.');

class Model_utils_dir 
{
									 
	
	public static function prep_directory($path)
	{
/*		try
		{
*/			if(!is_File($path) && !is_Link($path))
			{
				if(!is_Dir($path))
				{
					mkdir($path);
					if (substr(decoct(fileperms($path)), 1) != 0777)
						chmod($path, 0777);
				}
				return true;
			}
			else
			{
				throw new Kohana_Exception(':path is a file',
				array(':path' => Kohana::debug_path($path)));
			}
/*		}
		catch (Exception $e)
		{
			throw new Kohana_Exception('Could not create :path directory',
			array(':path' => Kohana::debug_path($path)));
		} */
	}
	
	public static function remove_directory($path)
	{
		try
		{
			// Constructs a new directory iterator from a path
			$dir = new DirectoryIterator($path);

			foreach ($dir as $fileinfo)
			{
				// Determine if current DirectoryIterator item is a regular file or symbolic link
				if ($fileinfo->isFile() || $fileinfo->isLink())
				{
					// Changes file mode
					if (substr(decoct(fileperms($fileinfo->getPathName())), 1) != 0777)
						chmod($fileinfo->getPathName(), 0777);

					// Deletes a file
					unlink($fileinfo->getPathName());
				}

				// Determine if current DirectoryIterator item is not '.' or '..' and is a directory
				elseif ( ! $fileinfo->isDot() && $fileinfo->isDir())
				{
					// Recursion
					self::remove_directory($fileinfo->getPathName());
				}
			}

			// Changes file mode
			if (substr(decoct(fileperms($path)), 1) != 0777)
				chmod($path, 0777);

			// Removes directory
			rmdir($path);
		}

		catch (Exception $e)
		{
			throw new Kohana_Exception('Could not remove :path directory',
				array(':path' => Kohana::debug_path($path)));
		}
	}

	final private function __construct()
	{
		// This is a static class
	}
}
