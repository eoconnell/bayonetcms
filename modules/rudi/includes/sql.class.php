<?php
/**
 * Bayonet Content Management System - RUDI
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


static $db_queries = 0;
static $db_connections = 0;
static $db_frees = 0;
static $db_fetches = 0;

class RUDI_SQL
{
  protected $hostname;
  public function Connect($hostname, $username, $passwd)
  {
    global $db_connections;
    ++$db_connections;
    
    $this->hostname = $hostname;
    
    decho("Connecting ('$hostname')");
    return mysql_connect($hostname, $username, $passwd);
  }
  
  public function Disconnect($link)
  {
    decho("Disconnecting ('$link' from '$this->hostname')");
    //return mysql_close($link);
  }
  
  public function Select_db($db)
  {
    decho("Selecting database ('$db')");
    return mysql_select_db($db);
  }
  
  public function Query($str)
  {
    global $db_queries;
    ++$db_queries;
    //decho("Querying ('$str')");
    return mysql_query($str);
  }
  
  public function Free($result)
  {
    global $db_frees;
    ++$db_frees;
    //decho("Freeing ('$result')");
    return mysql_free_result($result);
  }
  
  public function Fetch($result)
  {
    //decho("Fetching ('$result')");
    return $this->FetchArray($result);
  }
  
  public function FetchArray($result)
  {
    global $db_fetches;
    ++$db_fetches;
    /* Alias Fetch() prefered, so no decho information */  
    return mysql_fetch_array($result,MYSQL_ASSOC);
  }
    
  public function FetchObject($result,$class)
  {
    global $db_fetches;
    ++$db_fetches;
    //decho("Fetching ('$result')");
    return mysql_fetch_object($result,$class);
  }
  
  public function FetchAssoc($result)
  {
    global $db_fetches;
    ++$db_fetches;    
    return mysql_fetch_assoc($result);
  }
  
  public function FetchRow($result)
  {
    return mysql_fetch_row($result);
  }
  
  public function Rows($result)
  {
    return mysql_num_rows($result);
  }
}

?>
