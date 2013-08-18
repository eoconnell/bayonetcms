<?php

	/* EVERY THEME SHOULD HAVE THIS FILE WITH THE FUNCTIONS OPENCONTENT() & CLOSECONTENT() */
	
	/**
	* OpenContent()
	* Opens a Bayonet site content block.
	* @return
	*/
	function OpenContent()
	{
		echo "<div class=\"contentBorder1\">";
		echo "<div class=\"contentBorder2\">";
	}
	  
	/**
	* CloseContent()
	* Closes a Bayonet site content block.
	* @return
	*/
	function CloseContent()
	{
		echo "</div>";
		echo "</div>";
	}
	  
	function OpenBlock($title = 'New Block')
	{
	  OpenContent();
	  echo "<div class=\"contentHeading\">{$title}</div>";
	  echo "<div class=\"content\">";
	}
	
	function CloseBlock()
	{
	  echo "</div>";
	  CloseContent();
	}

?>