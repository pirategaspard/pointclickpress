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
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9_]+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	protected function isVariableOrNumeric($var)
	{
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	protected function isVariableOrNumericOrString($var)
	{
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+)|(\'\w.*\'+)|("\w.*"+))$/',$var))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	protected function isString($var)
	{
		if (preg_match('/^((\'\w.*\'+)|("\w.*"+))$/',$var))
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
	
	// given 1 + 1 will return '+' or 1 < 2 returns '<'
	protected function getOperators($expression)
	{
		$operators = array();
		if (preg_match('/[<=|>=|<>|!=|==|<|>|+|-|//|*|%]/',$expression, $ops))
		{
			$operators = $ops;
		}
		return $operators;
	}
	
	protected function getOperator($expression)
	{
		$operator = null;
		$operators = $this->getOperators($expression);
		if (count($operators)>0)
		{
			$operator = $operators[0];
		}
		return $operator;
	}
}

?>
