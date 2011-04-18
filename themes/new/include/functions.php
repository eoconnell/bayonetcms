<?php

	/* EVERY THEME SHOULD HAVE THIS FILE WITH THE FUNCTIONS OPENCONTENT() & CLOSECONTENT() */
	
	/**
	* OpenContent()
	* Opens a Bayonet site content block.
	* @return
	*/
	function OpenContent()
	{
		echo "OPEN CONTENT<br />";
	}
	  
	/**
	* CloseContent()
	* Closes a Bayonet site content block.
	* @return
	*/
	function CloseContent()
	{
		echo "CLOSE CONTENT<br />";
	}
	
	function OpenBlock($title = 'New Block')
	{
		echo "<h2 class=\"widgettitle\"><span>{$title}</span></h2>";
	}
	
	function CloseBlock()
	{
	}

?>