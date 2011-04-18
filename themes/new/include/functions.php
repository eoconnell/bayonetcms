<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008-2011  Joseph Hunkeler & Evan O'Connell
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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
