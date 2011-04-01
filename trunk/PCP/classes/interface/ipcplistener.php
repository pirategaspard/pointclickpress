<?php
/*
 	Interface for PointClickPress Listener Object
 */
interface Interface_iPCPListener
{	
	public function execute($event_name=''); // function that is called when event is broadcast. eventname is passed in.
}

?>
