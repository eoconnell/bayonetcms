<?php

define('RUDI_PROFILE_SMALL', true);
define('RUDI_PROFILE_BIG', false);

class Soldier
{
  public function __construct()
  {
    decho("Constructing " . get_class($this));
  }
  
  public function __destruct()
  {
    decho("Destructing " . get_class($this));
  }
}

class Award
{
  public function __construct()
  {
    decho("Constructing " . get_class($this));
  }
  
  public function __destruct()
  {
    decho("Destructing " . get_class($this));
  }
  
  public function __toString()
  {
    return $this->name;
  }  
}

class AwardClass
{
  public function __construct()
  {
    decho("Constructing " . get_class($this));
  }
  
  public function __destruct()
  {
    decho("Destructing " . get_class($this));
  }
  
  public function __toString()
  {
    return $this->name;
  }  
}

class Rank
{
  public function __construct()
  {
    decho("Constructing " . get_class($this));
  }
  
  public function __destruct()
  {
    decho("Destructing " . get_class($this));
  }
  
  public function __toString()
  {
    return $this->longname;
  }  
}

class Drill
{
  public function __construct()
  {
    decho("Constructing " . get_class($this));
  }
  
  public function __destruct()
  {
    decho("Destructing " . get_class($this));
  }
  
  public function __toString()
  {
    return $this->date;
  }  
}

/**
 * does Stat actually need to exist?
 */
class Stat
{
  
}

class RUDI_Common
{
  protected static $db, $link;
  protected $images_path;
  public $data;
  
  public function __construct()
  {
    global $config;
    $this->images_path = $config['rudi']['images_path'];
    $this->db = new Bayonet_SQL();
    $this->link = $this->db->Connect($config['sql']['hostname'], $config['sql']['username'], $config['sql']['password']);
    $this->db->Select_db('thirdid_oc');	
  }
  
  public function __destruct()
  {

  }

  /**
   * RUDI_SoldierProfile::date_diff()
   *  
   * This was posted by stoicnluv@gmail.com at php.net.
   * This function is assumed to be public domain source code.
   *   
   * @param mixed $d1
   * @param mixed $d2
   * @return
   */
  private function date_diff($d1, $d2){
      $d1 = (is_string($d1) ? strtotime($d1) : $d1);
      $d2 = (is_string($d2) ? strtotime($d2) : $d2);
  
      $diff_secs = abs($d1 - $d2);
      $base_year = min(date("Y", $d1), date("Y", $d2));
  
      $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
      return array(
          "years" => date("Y", $diff) - $base_year,
          "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
          "months" => date("n", $diff) - 1,
          "days_total" => floor($diff_secs / (3600 * 24)),
          "days" => date("j", $diff) - 1,
          "hours_total" => floor($diff_secs / 3600),
          "hours" => date("G", $diff),
          "minutes_total" => floor($diff_secs / 60),
          "minutes" => (int) date("i", $diff),
          "seconds_total" => $diff_secs,
          "seconds" => (int) date("s", $diff)
      );
  }

  /**
   * RUDI_SoldierProfile::getDiffTime()
   *
   * @param mixed $date
   * @return
   */
  protected function getDiffTime($date, $recent = NULL)
  {
  	if($recent == NULL)
    {
      $recent = time();
    }
  	
    $test = $this->date_diff($date, $recent);
    $y_mod = NULL;
    $m_mod = NULL;
    $d_mod = NULL;
    
    if($test['years'] > 1)
      $y_mod = 's';
    if($test['months'] > 1)
      $m_mod = 's';
    if($test['days'] > 1 && $test['days'] < 1)
      $d_mod = 's';
    
    if($test['years'] < 1 && $test['months'] < 1)
    {
      return '['. $test['days'] .'] Day' . $d_mod . ' ';
    }
    /* This code does not work properly under certain conditions
     * therefore it is commented, but left for prosterity's sake.
    elseif($test['days'] < 1)
    {
      return 'Less than a day';
    }*/
    else
    {
      return '[' . $test['years'] . '] Year' . $y_mod . ' [' . $test['months'] . '] Month' . $m_mod . ' ';
    }    
  }  
  
  protected function evalData($data)
  {
    return $data ? $data : "N/A";
  }
  
  protected function getCumulativeStats()
  {
    //$stats = array();
    $result = $this->db->Query("SELECT platoon_id AS id, name FROM rudi_platoons");
    $stats['platoon'] = mysql_num_rows($result);
    $result = $this->db->Query("SELECT squad_id AS id, name FROM rudi_squads");
    $stats['squad'] = mysql_num_rows($result);
    
    decho($stats['platoon']);
    decho($stats['squad']);
    $this->db->Free($result);
    
    return $stats;
  }
  
  protected function getMembersOfPlatoon($id)
  {
    $id = mysql_escape_string($id);
    $result = $this->db->Query("SELECT platoon_id AS id FROM rudi_unit_members WHERE platoon_id = '$id'");
    $members = mysql_num_rows($result);
    
    return (int)$members;
  }
  
  protected function getMembersOfSquad($id)
  {
    $id = mysql_escape_string($id);
    $result = $this->db->Query("SELECT squad_id AS id FROM rudi_unit_members WHERE squad_id = '$id'");
    $members = mysql_num_rows($result);
    
    return (int)$members;
  }
  
  protected function getSquadMembers($squad_id)
  {
    //$squad_id = addslashes($squad_id);
    $squad_id = mysql_escape_string($id);
    $result = $this->db->Query("SELECT m.last_name, 
    m.first_name, 
    r.shortname AS rank_short 
    FROM rudi_unit_members AS m 
    LEFT OUTER JOIN rudi_ranks AS r ON r.rank_id = m.rank_id WHERE m.squad_id = '$squad_id' ORDER BY m.rank_id ");
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
    
    return $data;
  }
  
  /**
   * RUDI_Core::getRoles()
   *
   * @param mixed $member_id
   * @param mixed $rank_id
   * @return
   */
  protected function getRoles($member_id, $rank_id)
  {
    $member_id = mysql_escape_string($member_id);
    $query =
    "SELECT r.role_id, "
    ."r.name AS role_name "
    ."FROM rudi_roles AS r "
    ."LEFT OUTER JOIN rudi_roles_container AS rl ON rl.role_id = r.role_id "
    ."RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = rl.member_id "
    ."WHERE m.member_id = '$member_id' ORDER BY r.name ASC";
    
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
    
    return $data;
  }

  /*
  protected function getRoles($member_id, $rank_id)
  {
    $query = sprintf(
    "SELECT r.role_id, "
    ."r.name AS role_name, "
    ."c.name AS class_name "
    ."FROM rudi_classes AS c "
    ."RIGHT OUTER JOIN rudi_roles AS r ON r.member_id = '%d' "
    ."LEFT OUTER JOIN rudi_ranks AS a ON a.class_id = c.class_id "
    ."WHERE a.rank_id = '%d' ORDER BY r.name ASC", 
    mysql_real_escape_string($member_id), 
    mysql_real_escape_string($rank_id)
    );
    
//    $result = $this->db->Query($query);
//    $data = $this->db->FetchObject($result,'Soldier');
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
    
    return $data;
  }
  */

  //NOT FINISHED :( :(
  /**
   * RUDI_Core::getServiceRecord()
   *
   * @param mixed $member_id
   * @return
   */
  protected function getServiceRecord($member_id)
  { 
  	$data = NULL;
    $query = sprintf( 
      "SELECT r.record_id, r.date_added, r.record_note "
      ."FROM rudi_service_record AS r "
      ."LEFT OUTER JOIN rudi_unit_members AS m ON m.member_id = r.member_id "
      ."WHERE r.member_id = '%d' ORDER BY r.date_added DESC", 
    mysql_real_escape_string($member_id));
    
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
       
    return $data;
  }
  
  /**
   * RUDI_Core::getAwardRecord()
   *
   * @param mixed $member_id
   * @return
   */
  protected function getAwardRecord($member_id)
  { 
  	$data = NULL;
    $query = sprintf( 
      "SELECT r.award_id, r.date_added, r.record_note, a.name AS award_name, a.image "
      ."FROM rudi_award_record AS r "
      ."RIGHT OUTER JOIN rudi_awards AS a ON a.award_id = r.award_id "
      ."LEFT OUTER JOIN rudi_unit_members AS m ON m.member_id = r.member_id "
      ."WHERE r.member_id = '%d' ORDER BY r.date_added DESC ", 
    mysql_real_escape_string($member_id));
    
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
       
    return $data;
  }

  /**
   * RUDI_Core::getCombatRecord()
   *
   * @param mixed $member_id
   * @return
   */
  protected function getCombatRecord($member_id)
  { 
  	$data = NULL;
    $query = sprintf( 
      "SELECT c.date, c.status, u1.name, u1.website, u.war_id "
      ."FROM rudi_combat_record AS c "
      ."RIGHT OUTER JOIN rudi_war_stats AS u ON u.visit_unit_id = c.visitor_id "
      ."RIGHT OUTER JOIN rudi_war_units AS u1 ON u1.name "
      ."LEFT OUTER JOIN rudi_unit_members AS m ON m.member_id = c.member_id "
      ."WHERE c.member_id = '%d' ORDER BY c.date DESC ", 
    mysql_real_escape_string($member_id));
    
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
       
    return $data;
  }

  /**
   * RUDI_Core::getSuperiorUnit()
   *
   * @param mixed $id
   * @return
   */
  protected function getSuperiorUnit($id)
  { 
    $query = sprintf(
      "SELECT leader_id, "
      ."CONCAT(m.last_name, \", \", m.first_name) AS name "
      ."FROM rudi_units AS u "
      ."RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = u.leader_id "
      ."WHERE u.unit_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    $this->db->Free($result);
    
    return $data;
  }

  /**
   * RUDI_Core::getSuperiorPlatoon()
   *
   * @param mixed $id
   * @return
   */
  protected function getSuperiorPlatoon($id)
  { 
    $query = sprintf(
      "SELECT leader_id, "
      ."CONCAT(m.last_name, \", \", m.first_name) AS name "
      ."FROM rudi_platoons AS p "
      ."RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = p.leader_id "
      ."WHERE p.platoon_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    $this->db->Free($result);
    
    return $data;
  }
  
  /**
   * RUDI_Core::getSuperiorSquad()
   *
   * @param mixed $id
   * @return
   */
  protected function getSuperiorSquad($id)
  { 
    $query = sprintf(
      "SELECT leader_id, "
      ."CONCAT(m.last_name, \", \", m.first_name) AS name "
      ."FROM rudi_squads AS s "
      ."RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = s.leader_id "
      ."WHERE s.squad_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    $this->db->Free($result);
    
    return $data;
  }

  /**
   * RUDI_Core::getSuperiorTeam()
   *
   * @param mixed $id
   * @return
   */
  protected function getSuperiorTeam($id)
  { 
    $query = sprintf(
      "SELECT leader_id, "
      ."CONCAT(m.last_name, \", \", m.first_name) AS name "
      ."FROM rudi_teams AS t "
      ."RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = t.leader_id "
      ."WHERE t.team_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    $this->db->Free($result);
    
    return $data;
  }
  
  /**
   * RUDI_Core::getSuperiorTrue()
   *
   * @param mixed $id
   * @return
   */
  protected function getSuperiorTrue($id)
  {
    $superior =& $this->data[$id]->superior; //Reference only the data we need to use
    $name =& $this->data[$id]->name;
    $leader = NULL; //Set the return value to null
    
    /** If the data is not null/empty, and is not equaled to the member's name
      * (to avoid leaders from leading themself) then return the next leader in line.
      */
    
    foreach($superior as $tier => $value)
    {
      //$tier is 'unit','platoon','squad','team'
      //$value is the array underneath that has 'name', and 'leader_id'
  
      if(!empty($value->name) && $value->name != $name)
        $leader = $value;
      
    }
    
    return $leader;
  }
  
  /**
   * RUDI_Core::getUnit()
   *
   * @param mixed $id
   * @return
   */
  protected function getRosterUnit($id)
  { 
    $query = sprintf(
      "SELECT name "
      ."FROM rudi_units AS u "
      ."LEFT OUTER JOIN rudi_unit_members AS m ON m.unit_id = u.unit_id "
      ."WHERE m.member_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
    return $data;
  }

  /**
   * RUDI_Core::getPlatoon()
   *
   * @param mixed $id
   * @return
   */
  protected function getRosterPlatoon($id)
  { 
    $query = sprintf(
      "SELECT name "
      ."FROM rudi_platoons AS p "
      ."LEFT OUTER JOIN rudi_unit_members AS m ON m.platoon_id = p.platoon_id "
      ."WHERE m.member_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    return $data;
  }
  
  /**
   * RUDI_Core::getSquad()
   *
   * @param mixed $id
   * @return
   */
  protected function getRosterSquad($id)
  { 
    $query = sprintf(
      "SELECT last_name "
      ."FROM rudi_unit_members AS m "
      ."WHERE m.squad_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
    return $data;
  }

  /**
   * RUDI_Core::getTeam()
   *
   * @param mixed $id
   * @return
   */
  protected function getRosterTeam($id)
  { 
    $query = sprintf(
      "SELECT leader_id, "
      ."CONCAT(m.last_name, \", \", m.first_name) AS name "
      ."FROM rudi_teams AS t "
      ."RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = t.leader_id "
      ."WHERE t.team_id = '%d' ", 
      mysql_real_escape_string($id));
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
    return $data;
  }
  
  public function Update($query_t = RUDI_PROFILE_BIG)
  {
    $id = NULL;
    if(isset($_GET['profile']))
    {
      $id = addslashes($_GET['profile']);
      decho("Update() ID: $id");
    }
    
    if($query_t != RUDI_PROFILE_SMALL)
    {
      $sql = 
        "SELECT "
          ."m.email, "
          ."m.xfire, "
          ."m.first_name, "
          ."m.last_name, "
          ."m.member_id, "
          ."m.status_id, "
          ."m.bio, "
          ."m.image AS member_image, "
          ."m.location_city, "
          ."m.location_province, "
          ."r.rank_id, "
          ."r.image AS rank_image, "
          ."r.longname AS rank_long, "
          ."r.shortname AS rank_short, "
          ."c.name AS position, "
          ."u.unit_id, "
          ."u.name AS unit_name, "
          ."p.platoon_id, "
          ."p.name AS platoon_name, "
          ."s.squad_id, "
          ."s.name AS squad_name, "
          ."s.leader_id AS squad_leader_id, "
          ."st.name AS status, "
          ."st.status_id, "
          ."t.team_id, "
          ."t.name AS team_name, "
          ."t.leader_id AS team_leader_id, "
          ."w.weapon_id, "
          ."w.manufacturer AS weapon_manufacturer, "
          ."w.model AS weapon_model, "
          ."co.country_id, "
          ."co.name AS country_name, "
          ."co.image AS country_image, "
  
          ."CONCAT(m.last_name, \", \", m.first_name) AS name, "
          ."CONCAT(m.location_province, \", \", co.name) AS location, "
          ."CONCAT(w.manufacturer, \" \", w.model) as weapon_name, "
  
          ."DATE_FORMAT(m.date_enlisted, '%d %b %Y') AS enlist_date, "
          ."DATE_FORMAT(m.date_promotion, '%d %b %Y') AS promo_date, "
          ."DATE_FORMAT(m.date_discharged, '%d %b %Y') AS discharge_date, "
          
          ."m.date_enlisted AS enlist_date_st, "
          ."m.date_promotion AS promo_date_st, "
          ."m.date_discharged AS discharge_date_st "
          
        ."FROM rudi_unit_members AS m "
            ."LEFT OUTER JOIN rudi_weapons AS w ON w.weapon_id = m.weapon_id "
            ."LEFT OUTER JOIN rudi_units AS u ON u.unit_id = m.unit_id "
            ."LEFT OUTER JOIN rudi_squads AS s ON s.squad_id = m.squad_id "
            ."LEFT OUTER JOIN rudi_teams AS t ON t.team_id = m.team_id "
            ."LEFT OUTER JOIN rudi_platoons AS p ON p.platoon_id = m.platoon_id "
            ."LEFT OUTER JOIN rudi_ranks AS r ON r.rank_id = m.rank_id "
            ."LEFT OUTER JOIN rudi_classes AS c ON c.class_id = r.class_id "
            ."LEFT OUTER JOIN rudi_statuses AS st ON st.status_id = m.status_id "
            ."LEFT OUTER JOIN rudi_countries AS co ON co.country_id = m.country_id ";
    }
    else //SMALL PROFILE QUERY
    {
      $sql = 
        "SELECT "
          ."m.first_name, "
          ."m.last_name, "
          ."m.member_id, "
          ."m.status_id, "
          ."r.rank_id, "
          ."r.image AS rank_image, "
          ."r.longname AS rank_long, "
          ."r.shortname AS rank_short, "
          ."u.unit_id, "
          ."u.name AS unit_name, "
          ."p.platoon_id, "
          ."p.name AS platoon_name, "
          ."s.squad_id, "
          ."s.name AS squad_name, "
          ."s.leader_id AS squad_leader_id, "
          ."st.name AS status, "
          ."st.status_id, "
          ."t.team_id, "
          ."t.name AS team_name, "
          ."w.weapon_id, "
          ."w.manufacturer AS weapon_manufacturer, "
          ."w.model AS weapon_model, "
  
          ."CONCAT(m.last_name, \", \", m.first_name) AS name, "
          ."CONCAT(w.manufacturer, \" \", w.model) as weapon_name "
          
        ."FROM rudi_unit_members AS m "
            ."LEFT OUTER JOIN rudi_weapons AS w ON w.weapon_id = m.weapon_id "
            ."LEFT OUTER JOIN rudi_units AS u ON u.unit_id = m.unit_id "
            ."LEFT OUTER JOIN rudi_squads AS s ON s.squad_id = m.squad_id "
            ."LEFT OUTER JOIN rudi_teams AS t ON t.team_id = m.team_id "
            ."LEFT OUTER JOIN rudi_platoons AS p ON p.platoon_id = m.platoon_id "
            ."LEFT OUTER JOIN rudi_ranks AS r ON r.rank_id = m.rank_id "
            ."LEFT OUTER JOIN rudi_statuses AS st ON st.status_id = m.status_id ";
    }                                        
        
    if(!is_null($id))
    {
      $sql .= "WHERE m.member_id = '" . (int)$id . "' ";  
    }
          
    $sql .= "ORDER BY p.platoon_id,s.squad_id,t.team_id,r.rank_id DESC ";          
    $result = $this->db->Query($sql);
    $count = 0;
    
    while(($row = $this->db->FetchObject($result,'Soldier'))!=false)
    {
      $count = $row->member_id;
      $this->data[$row->member_id] = $row;
      $this->data[$count]->Roles = $this->getRoles($row->member_id,$row->rank_id);
      if($query_t != RUDI_PROFILE_SMALL)
      {
        $this->data[$count]->service_record = $this->getServiceRecord($row->member_id);
        $this->data[$count]->award_record = $this->getAwardRecord($row->member_id);
        $this->data[$count]->combat_record = $this->getCombatRecord($row->member_id);
        $this->data[$count]->superior->unit = $this->getSuperiorUnit($row->unit_id);
        $this->data[$count]->superior->platoon = $this->getSuperiorPlatoon($row->platoon_id);
        $this->data[$count]->superior->squad = $this->getSuperiorSquad($row->squad_id);
        $this->data[$count]->superior->team = $this->getSuperiorTeam($row->team_id);
        $this->data[$count]->superior_next = $this->getSuperiorTrue($row->member_id);               
      }
      //++$count;      
    }      
    $this->db->Free($result);
    
    return $this->data;
  }
  
  protected function getAwards()
  {
    $query = "SELECT a.award_id, a.image, a.name, a.description, a.class_id, c.name AS class_name "
      ."FROM rudi_awards AS a "
      ."LEFT OUTER JOIN rudi_award_classes AS c ON c.class_id = a.class_id "
      ."ORDER BY c.class_id, a.award_id ASC";
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Award'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
    
    return $data;  
  }
  
  protected function getAwardClasses()
  {
    $query = "SELECT class_id, name FROM rudi_award_classes";
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'AwardClass'))!=false)
    {
      $data[] = $row;    
    }
    $this->db->Free($result);
    
    return $data;
  }
  
  protected function getRanks()
  {
    $query = "SELECT rank_id, shortname, longname, image FROM rudi_ranks ORDER BY weight DESC";
    $result = $this->db->Query($query);
    while(($row = $this->db->FetchObject($result,'Rank'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
    
    return $data;  
  }  
  
  protected function getDrills($id = NULL)
  {
    if(!is_null($id))
    {
      $query = "SELECT * FROM rudi_drills  
      LEFT OUTER JOIN rudi_drills_record AS dr ON dr.drill_id = rudi_drills.drill_id 
      RIGHT OUTER JOIN rudi_unit_members AS m ON m.member_id = dr.member_id 
      LEFT OUTER JOIN rudi_statuses AS st ON st.status_id = m.status_i 
      WHERE rudi_drills.drill_id = '$id' ORDER BY date DESC";
    }
    else
    {
      $query = "SELECT * FROM rudi_drills ORDER BY date DESC";      
    }
    
    $result = $this->db->Query($query);      
    while(($row = $this->db->FetchObject($result,'Drill'))!=false)
    {
      $data[] = $row;
    }
    $this->db->Free($result);
    
    return $data;  
  }
}

?>