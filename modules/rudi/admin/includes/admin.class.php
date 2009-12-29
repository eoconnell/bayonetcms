<?php
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