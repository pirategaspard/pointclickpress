<?php
/*
	Base Class for PointClickPress Events
 */
class pcpevent extends model 
{
	protected $event = '';
	protected $label = '';
	protected $description = '';

	public function __construct()
	{
		$this->event = get_class($this);	
	}
	
	public function getLabel()
	{
		return $this->label;
	}
	
	public function getDescription()
	{
		return $this->description;
	}
	
	public function execute($args=array(),$session=null)
	{
		// this function is meant to be extended 
	}
	
	public function __get($prop)
	{			
		return $this->$prop;
	}
	
	protected function isVariable($var)
	{
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	// given "$myvariable" returns "myvariable"
	protected function getVariableName($var)
	{
		return preg_replace('[\$| ]','',$var);
	}
	
	// given "$myvariable" returns "myvariable"
	protected function replaceSessionVariables($expression)
	{
		/* 
			replace any variables with their session global equivalents 
			in order to be able to reference variables in session['data']. 
		*/	
		return preg_replace('/(\$(\w+\b))/',"\$session['data']['$2']",$expression);
	}
}

?>
