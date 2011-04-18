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

/*
class Rank
{
  public function __toString()
  {
    return $this->longname;
  }
}

class Award
{
  public function __toString()
  {
    return $this->name;
  }
}
*/

class AdminCommon extends RUDI_Common
{
  public function __construct()
  {
    parent::__construct();
    $this->Update();
  }
  
  public function getRanks()
  {
    $result = $this->db->Query("SELECT * FROM rudi_ranks");
    while(($row = $this->db->FetchObject($result,'Rank'))!=false)
    {
      $ranks[] = $row;
    }
    
    return $ranks;
  }
  
  public function getAwards()
  {
    $result = $this->db->Query("SELECT * FROM rudi_awards");
    while(($row = $this->db->FetchObject($result,'Award'))!=false)
    {
      $awards[] = $row;
    }
    
    return $awards;    
  }
}

class AdminAdd
{
  protected $db, $link, $id;
  public $data;
  
  public function __construct()
  {
    if(is_null($id))
    {
      decho("No ID");
      return;
    }
    $this->id = $id;
    
    $this->db = new RUDI_SQL();
    $this->link = $this->db->Connect('localhost','hunkeler','proball');
    $this->db->Select_db('rudi');	
    
    //$result = $this->db->Query("INSERT INTO rudi_unit_members VALUES()");
    //$name = $this->db->FetchArray($result);

    echo "Current soldier selected: '{$name['last_name']}, {$name['first_name']}'";
  }
  
  public function __set($var, $val)
  {
    //echo "UPDATE rudi_unit_members SET $var = '$val';";
    //mysql_query("UPDATE rudi_unit_members SET $var = '$val';");
    $this->id = addslashes($this->id);
    $this->db->Query("UPDATE rudi_unit_members SET $var = '$val' WHERE member_id = '{$this->id}';");
  }
}

class AdminModify
{
  protected $db, $link, $id;
  public $data;
  
  public function __construct($id)
  {
    if(is_null($id))
    {
      decho("No ID");
      return;
    }
    else
    {
      decho(get_class($this) . "received: $id" );
    }
    $this->id = $id;
    
    $this->db = new RUDI_SQL();
    $this->link = $this->db->Connect('localhost','hunkeler','proball');
    $this->db->Select_db('rudi');	
    
    $result = $this->db->Query("SELECT last_name, first_name FROM rudi_unit_members WHERE member_id = '$id'");
    $name = $this->db->FetchArray($result);

    echo "Current soldier selected: '{$name['last_name']}, {$name['first_name']}'";
  }
  
  public function __set($var, $val)
  {
    //echo "UPDATE rudi_unit_members SET $var = '$val';";
    //mysql_query("UPDATE rudi_unit_members SET $var = '$val';");
    $this->id = addslashes($this->id);
    $this->db->Query("UPDATE rudi_unit_members SET $var = '$val' WHERE member_id = '{$this->id}';");
  }
}

?>
