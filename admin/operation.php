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
 
if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
  return;
}

if(!isset($_GET['op']))
{
  echo "<center>No operation selected</center>\n";
  return;
}

$op = $_GET['op'];
$basedir = './';

if(file_exists($basedir))
{
  if(file_exists($basedir . $op))
  {
    include $basedir . $op . '/index.php';  
  }
  else
  {
    ReportError("Administrative operation '$op' does not exist.");
  }
}
else
{
  ReportError("Administrative base directory path does not exist.");
}



?> 