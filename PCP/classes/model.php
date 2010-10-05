<?php defined('SYSPATH') or die('No direct script access.');
// extend Kohana model so that all PCP classes that extend from model have magic getter
class Model extends Kohana_Model 
{
	function __get($prop)
	{			
		return $this->$prop;
	}
}
