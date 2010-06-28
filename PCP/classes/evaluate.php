<?php defined('SYSPATH') or die('No direct script access.');

class Evaluate
{	
	/*
		Parse()
		parses Triggers and the variables for each scene 
	*/	
	static public function parse($exp_string='')
	{
		/* 
			loop over all possible events and pass in
			a string that may contain expressions that 
			can be evaluated by a action
		*/
		$session = Session::instance();
		$events = Events::getEventTypes();
		foreach($events as $event)
		{
			//echo($event->label);
			$event->execute(array('event_value'=>$exp_string),&$session);			
			//echo($_SESSION);
		}
		//die();
	}
}
