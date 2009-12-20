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

if(isset($_GET['load']))
    $load = $_GET['load'];

if(isset($_GET['file']))
    $file = $_GET['file'];

if(is_null($load))
{
  $load = $config['modules']['default'];
}

$deny_chars = $config['modules']['deny_chars'];

$load_temp = $load;

/*
 * broken i guess.
for($chars = 0; $chars <= strlen($load_temp); ++$chars)
{
  foreach($deny_chars as $deny)
  {
    if($load_temp[$chars] == $deny)
    {
      OpenTable();
      ReportHack("Invalid characters detected.\n");
      CloseTable();       
    } 
  }
}
*/
if(isset($load) && !empty($load) && !isset($file))
{
  if(file_exists("modules/" . $load))
  {
    include 'modules/' . $load . '/index.php';
  }
  else
  {
    ReportError("Cannot load module directory.<br>\n"); 
  }
}
elseif(isset($load) && isset($file))
{
  if(file_exists("modules/" . $load))
  {
    //$file_temp = explode('.',$file);
    //$file = $file_temp[0];
  
    $run = "modules/" . $load . "/" . $file;
    
    if(file_exists($run))
    {
      include $run;     
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