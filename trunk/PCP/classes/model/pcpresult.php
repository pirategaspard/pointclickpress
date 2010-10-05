<?php defined('SYSPATH') or die('No direct script access.');

class Model_PCPResult 
{
	protected $success = 0;
	protected $message = '';
	protected $data = NULL;

	public function __construct($s=0,$m='',$d=NULL)
	{		
		$this->success = $s;
		$this->message = $m;
		$this->data = $d;		
	}
	
	public function __get($prop)
	{			
		return $this->$prop;
	}
	
	public function __set($prop, $value)
	{			
		$this->$prop = $value;
	}
}
?>
