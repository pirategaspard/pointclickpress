<?php defined('SYSPATH') or die('No direct script access.');


define('PCPRESULT_CLASS_INFO', 'info');
define('PCPRESULT_CLASS_SUCCESS', 'success');
define('PCPRESULT_CLASS_ERROR', 'error');

define('PCPRESULT_STATUS_INFO', '-1');
define('PCPRESULT_STATUS_SUCCESS', '1');
define('PCPRESULT_STATUS_ERROR', '0');

class Model_Base_PCPResult 
{
	protected $success = 0;
	protected $message = '';
	protected $data = NULL;

	public function __construct($s=PCPRESULT_STATUS_INFO,$m='',$d=NULL)
	{		
		$this->success = $s;
		$this->message = $m;
		$this->data = $d;		
	}
	
	public function getClass()
	{
		switch ($this->success)
		{
			case PCPRESULT_STATUS_SUCCESS:
			{
				$class = PCPRESULT_CLASS_SUCCESS;
				break;
			}
			case PCPRESULT_STATUS_INFO:
			{
				$class = PCPRESULT_CLASS_INFO;
				break;
			}
			case PCPRESULT_STATUS_ERROR:
			{
				$class = PCPRESULT_CLASS_ERROR;
				break;
			}
			default:
			{
				$class = PCPRESULT_CLASS_INFO;
				break;
			}
		}
		return $class;
	}
	
	public function printMessage()
	{
		return '<div class="'.$this->getClass().'">'.$this->message.'</div>';
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
