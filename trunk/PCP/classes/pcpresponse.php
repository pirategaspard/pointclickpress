<?php defined('SYSPATH') or die('No direct script access.');

class pcpresponse
{	
	public $function_name = '';
	public $data = array();
	
	function __construct($function_name,$data)
	{
		$this->function_name = $function_name;
		$this->data = $data;
	}
	
	function asArray()
	{
		$a = array();
		$a[] = $this;
		return $a;
	}
}
