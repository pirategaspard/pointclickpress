<?php defined('SYSPATH') or die('No direct script access.');

class Evaluate
{	
	/*
		Parse()
		parses Triggers and the variables for each scene 
	*/	
	static public function parse($vars='')
	{
		$parsed = array();
		$session = Session::instance();
		$globals = $session->get('globals',array());		
		
		/* 
			valid name_val_pairs: $vars = '$found_item = 0; $total_money = $total_money + 1;'
		*/
		try
		{
			$name_val_pairs = explode(';',$vars); 					
			foreach($name_val_pairs as $expression)
			{
				// only evaluate if they are assigning a value;
				$temp = explode('=',$expression);
				if (count($temp) == 2) 
				{
					// make sure the left side has a valid variable name;
					if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+))$/',$temp[0]))
					{
						$var = preg_replace('[\$| ]','',$temp[0]); //remove the $ to get just the variable name
						$exp = trim($temp[1]);
						
						/* 
							replace any variables with their session global equivalents 
							in order to be able to reference variables in session['globals']. 
						*/	
						$expression = preg_replace('/(\$(\w+\b))/',"\$globals['$2']",$expression);
						
						if (Evaluate::valid($exp))
						{
							/*
								Using eval() on user submitted data has the 
								potential to be a security problem, but we 
								have checked this expression against a whitelist
								and should now have only a valid expression
							 */
							$parsed[$var] = eval('return '.$expression.';'); 
						}
					}
				}
			}
		}
		catch(Exception $e)
		{
			echo '"'.$expression.';"'.'is not valid PHP.';
			var_dump($e); die();
		}
		return $parsed;
	}
	
	
	/*
		Valid()
		This function checks the user submited expression against allowed
		expression types.  Allowed expressions are:
		
		simple value:  '1' or '$y'
		basic math:  '1 + $y'
		inline if:   '($x>$y)?1:0'		
	
		all other statements are invalid. 
	 */
	static private function valid($exp='')
	{
		$valid = 0;
		/* 
			SIMPLE VALUE
			detect simple value statement in the form of 
			1; or $var;
		*/
		if (preg_match('/^((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))$/',$exp))
		{
			//echo (' simple: ');
			$valid = 1;
		}
		
		/* 
			MATH
			detect math statement in the form of 
			$var + 1; $var - 1; 1 * 1; $var + $var; $var['blah'] + $var['blah'];
		*/
		if (preg_match('/((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\s*([\+\-\*\/])\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))/',$exp))
		{
			//echo (' math: ');
			$valid = 1;
		}
		
		/* 
			IF
			detect if statement in the form of 
			($var)?val1:val2; ($var[0]>5) ? val1 : val2; 
		*/
		if (preg_match('/\(((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\s*(\>|\<|\={2}|!=)\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\)\s*\?\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))\s*:\s*((\$[a-zA-Z\'\[\]0-9]+)|([0-9]+))/',$exp))
		{
			//echo (' if? ');
			$valid = 1; 
		}
		
		// Will probably need to support plug-in functions here as well. 
		
		return $valid;
	}
}
