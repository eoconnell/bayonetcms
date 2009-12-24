<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler
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
 
define("MODULE_FILE",true);
global $load,$index_module;

/**
 * Assign _GET variables
 */
if(isset($_GET['load']))
    $load = $_GET['load'];

if(isset($_GET['file']))
    $file = $_GET['file'];

/** 
 * Determine the default module to load
 */
if(is_null($load))
{
	$load = $config['modules']['default'];
}

/**
 * If the error stack has recieved messages, output each failure in a clean fashion 
 */
global $error_stack_messages;
if(!empty($error_stack_messages))
{
	$messageBuffer = NULL;
	foreach($error_stack_messages as $order => $error)
	{
		$messageBuffer .= "<p><b>Stack Order:</b> $order<br/>$error</p>";
	}
	ReportError($messageBuffer);
	//exit(1);
}

$module_path = "modules/" . $load;
$module_index = $module_path . "/index.php";
$module_internal_file = "modules/" . $load . "/" . $file;

/** Sanity Check
 * If the module or a file associated with the module is a symbolic link then
 * commit suicide.  Symbolic links to malicious code can be dangerous. 
 */
if(isset($load) || isset($file))
{
	if(is_link($module_path))
	{
		decho("Refusing to follow symbolic link to '$load'");
		exit(1);	
	}
	
	if(is_link($module_internal_file))
	{
		decho("Refusing to follow symbolic link to '$file'");
		exit(1);
	}
}

/** Sanity Check
 * Determine if the module or file passed into $load actually exists
 * If everything checks out, load the module or file, else commit suicide.
 */
if(isset($load) && !empty($load) && !isset($file))
{	
    if(file_exists($module_path))
	{
		include $module_index;
		decho("'$load' module loaded");
    }
    else
    {
        ReportError("Cannot load module directory.<br>\n"); 
    }
}
/**
 * Load an internal module file
 */
elseif(isset($load) && isset($file))
{
	if(file_exists($module_path))
	{    	
    	if(file_exists($module_internal_file))
    	{	
      		include $module_internal_file;
	  		decho("Loaded '$file' file from $load module");     
    	}
    	else
    	{
      		ReportError("Cannot load module directory.<br>\n");     
    	}
	}
	else
	{
    	ReportError("Cannot load module file.<br>\n");
	}
}
else
{
	ReportError("Failure to load module.<br>\n");  
}


?>