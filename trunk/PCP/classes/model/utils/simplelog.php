<?php defined('SYSPATH') or die('No direct script access.');

class Model_Utils_SimpleLog extends Kohana_Log_File {

	public function addMessage($message='',$level=LOG_INFO,$time='')
	{
		$m = array(	'body'=>$message,
					'level'=>$level,
					'time'=>time()
					);
		$ms[] = $m;
		parent::write($ms);
	}

} 
