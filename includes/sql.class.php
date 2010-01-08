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

static $db_queries = 0;
static $db_connections = 0;
static $db_frees = 0;
static $db_fetches = 0;

class Bayonet_SQL
{
  protected $hostname;
  public function Connect($hostname, $username, $passwd)
  {
    global $db_connections;
    $db_connections++;
    
    $this->hostname = $hostname;
    
    decho("Connecting ('$hostname')");
    return ($GLOBALS['___mysqli_ston'] = mysqli_connect($hostname,  $username,  $passwd));
  }
  
  public function Disconnect($link)
  {
    decho("Disconnecting ('$link' from '$this->hostname')");
    return mysqli_close($GLOBALS['___mysqli_ston']);
  }
  
  public function Stat()
  {
  	return mysqli_stat($GLOBALS['___mysqli_ston']);
  }
  
  public function Select_db($db)
  {
    decho("Selecting database ('$db')");
    return mysqli_select_db($GLOBALS['___mysqli_ston'], $db);
  }
  
  public function Query($str)
  {
    global $db_queries;
    $db_queries++;
    return mysqli_query($GLOBALS['___mysqli_ston'], $str); 
  }
  
  public function Free($result)
  {
    global $db_frees;
    $db_frees++;
    @((mysqli_free_result($result) || (is_object($result) && (get_class($result) == "mysqli_result"))) ? true : false);
  }
  
  public function Fetch($result)
  {
    return $this->FetchArray($result);
  }
  
  public function FetchArray($p_result)
  {
  	global $db_fetches;
	$db_fetches++;
	decho('Fetching result');
	
	while ($row = mysqli_fetch_array($p_result, MYSQLI_ASSOC)) 
	{
		$result[] = $row;
	}
	$this->Free($p_result);
	
	return is_array($result) ? $result : array();
  }
    
  public function FetchObject($p_result, $class, $no_array = false)
  {
    global $db_fetches;
    $db_fetches++;
    
    decho("Fetching object result");
    
    while ($row = mysqli_fetch_object($p_result, $class))
	{
		if($no_array == true) 
			(object)$result = $row;
		else
			(object)$result[] = $row;
    }
    
    $this->Free($p_result);
    
    // TODO: Test for objects inside of $result array
    if($no_array == true) { return is_object($result) ? $result : (object)$nothing; }
    return is_array($result) ? $result : (object)array();
  }
  
  public function FetchAssoc($result)
  { 
    return $this->FetchArray($result);
  }
  
  public function FetchRow($p_result)
  {
    global $db_fetches;
    $db_fetches++;
    
  	decho("Fetching single row");
  	
  	while ($row = mysqli_fetch_assoc($p_result)) {
  	  $result = $row;
  	}
  	
  	$this->Free($p_result);
  	
    return is_array($result) ? $result : array();
  }
  
  public function Rows($result)
  {
  	decho("Fetching number of rows");
  	
    return mysqli_num_rows($result);
  }
}

?>
