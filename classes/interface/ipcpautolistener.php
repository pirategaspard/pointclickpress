<?php 

interface Interface_iPCPAutoListener extends Interface_iPCPListener
{
	public function getEvents(); // events class to be automatically registered to listen for on request start	
}
?>
