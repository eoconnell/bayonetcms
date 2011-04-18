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


define('RUDI_PROFILE_SMALL', true);
define('RUDI_PROFILE_BIG', false);
define('RUDI_ROSTER_RESERVES', 12);

class Soldier
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
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

class Role
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
  }
  
  public function __destruct()
  {
    decho("Destructing " . get_class($this));
  }
  
  public function __toString()
  {
    return $this->role_name;
  }    
}

class UnitInfo
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
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

class Award
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
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
    decho("Constructing " . get_class($this) . " -> " . $this);
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
    decho("Constructing " . get_class($this) . " -> " . $this);
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
	public $members;
	public function __construct()
	{
		decho("Constructing " . get_class($this) . " -> " . $this);
		//$this->members = array('Newly constructed');
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

class ServiceRecord
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
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

class AwardRecord
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
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

class CombatRecord
{
  public function __construct()
  {
    decho("Constructing " . get_class($this) . " -> " . $this);
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
  	decho("Constructing " . get_parent_class($this));
    global $config, $db;
    
    $this->images_path = $config['rudi']['images_path'];
    $this->db = $db;	
  }
  
  public function __destruct()
  {
  	decho("Destructing " . get_parent_class($this));
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
    
    if($test['years'] > 1 || $test['years'] < 1)
      $y_mod = 's';
    if($test['months'] > 1 || $test['months'] < 1)
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
  	if(is_array($data))
		  return (count($data) < 1) ? true : false;
	else
    	return $data ? $data : "N/A";
  }
  
  protected function getCumulativeStats()
  {
    //$stats = array();
    $result = $this->db->Query("SELECT platoon_id AS id, name FROM rudi_platoons");
    $stats['platoon'] = $this->db->Rows($result);
    $result = $this->db->Query("SELECT squad_id AS id, name FROM rudi_squads");
    $stats['squad'] = $this->db->Rows($result);
    
    decho($stats['platoon']);
    decho($stats['squad']);
	 
    return $stats;
  }
  
  protected function getMembersOfPlatoon($id)
  {
    $query = sprintf("SELECT platoon_id AS id FROM rudi_unit_members WHERE platoon_id = %d", (int)$id);
    $result = $this->db->Query($query);
    $members = $this->db->Rows($result);

    return (int)$members;
  }
  
  protected function getMembersOfSquad($id)
  {
    $query = sprintf("SELECT squad_id AS id FROM rudi_unit_members WHERE squad_id = %d", (int)$id);
    $result = $this->db->Query($query);
    $members = $this->db->Rows($result);
    
    return (int)$members;
  }
  
  protected function getSquadMembers($squad_id)
  {
    $query = sprintf("SELECT m.last_name, 
    m.first_name, 
    r.shortname AS rank_short 
    FROM rudi_unit_members AS m 
    LEFT OUTER JOIN rudi_ranks AS r ON r.rank_id = m.rank_id WHERE m.squad_id = %d ORDER BY m.rank_id ",
	(int)$squad_id);
	
	$result = $this->db->Query($query);
    $row = $this->db->FetchObject($result,'Soldier');

    return $row;
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
  	$data = NULL;
	$query = sprintf("SELECT r.role_id, r.name AS role_name FROM rudi_roles AS r LEFT OUTER JOIN rudi_roles_container AS rl USING(role_id) INNER JOIN rudi_unit_members AS rm USING(member_id) WHERE rm.member_id = %d AND r.name IS NOT NULL ORDER BY r.role_id ASC", 
	(int)$member_id);	
    
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Role');
    
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
      ."WHERE r.member_id = %d ORDER BY r.date_added DESC", 
    (int)$member_id);
    
    $result = $this->db->Query($query);
   	$data = $this->db->FetchObject($result,'ServiceRecord');
    
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
      ."WHERE r.member_id = %d ORDER BY r.date_added DESC ", 
    (int)$member_id);
    
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'AwardRecord');
    
       
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
      "SELECT s.title, s.date, s.status, u1.name, u1.website, s.war_id, s.home_score, s.visit_score "
      ."FROM rudi_combat_record AS c "
      ."RIGHT OUTER JOIN rudi_war_stats AS s ON s.war_id = c.war_id "
      ."RIGHT OUTER JOIN rudi_war_units AS u1 ON u1.visitor_id = s.visit_unit_id "
      ."WHERE c.member_id = %d ORDER BY s.date DESC ", 
    (int)$member_id);
    
    $result = $this->db->Query($query);

    $data = $this->db->FetchObject($result,'CombatRecord');
	
    return $data;
  }
  
 /**
   * RUDI_Common::getUnitArr()
   *
   * @param member_id $mID
   * @return an array of the member's units orders from Team - Unit with name, id, & leader
   */
  function getUnitArr($mID){
  	$unitArr = array();
  	
  		$result = $this->db->Query("SELECT * FROM `rudi_unit_members` WHERE `member_id` = $mID LIMIT 1");
  		$member = $this->db->FetchRow($result);
		$curUnit = $member['cunit_id'];

		$i = 0;
	
	$subOf = $curUnit;
	while($subOf != 0){
		$unitID = $subOf; 
		$result = $this->db->Query("SELECT * FROM `rudi_combat_units` WHERE `unit_id` = $subOf LIMIT 1");
		$data = $this->db->fetch($result);
		foreach($data as $units){ 
			$subOf = $units['detachment'];
			$leader = $units['leader_id'];
			$name = $units['name'];
    	}

		$unitArr[$i]['unit_id'] = $unitID;
		$unitArr[$i]['leader_id'] = $leader;
		$unitArr[$i]['name'] = $name;
				
		
	//	echo "Unit ID: ".$unitArr[$i]['unit_id']."<br />Name: ".$unitArr[$i]['name']."<br />Leader ID: ".$unitArr[$i]['leader_id']."<br /><br />";
			
		$i++;	
	}
				
		return array_reverse($unitArr);
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
      ."WHERE u.unit_id = %d ", 
      (int)$id);
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
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
      ."WHERE p.platoon_id = %d ", 
      (int)$id);
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
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
      ."WHERE s.squad_id = %d ", 
      (int)$id);
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
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
      ."WHERE t.team_id = %d ", 
      (int)$id);
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
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
   * RUDI_Core::getSuperior($unit_id)
   *
   * @param mixed $unit_id
   * @return
   */
  protected function getSuperior($id)
  {
  	$leader = NULL;
  	$unit_id = $this->data[$id]->unit_id;

  	$result = $this->db->Query("SELECT `leader_id`, `detachment` FROM `rudi_combat_units` WHERE `unit_id` = '$unit_id' LIMIT 1");
  	$row = $this->db->FetchRow($result);
  	
  	$detachment = $row['detachment'];
  	$leader_id = $row['leader_id'];
	if($leader_id == $id){
		$leader_id = 0;	
	}
  	while($leader_id == 0){
			if($detachment == 0){
				break;			
			}
  		  	$result = $this->db->Query("SELECT `leader_id`, `detachment` FROM `rudi_combat_units` WHERE `unit_id` = '$detachment' LIMIT 1");
		  	$row = $this->db->FetchRow($result);	
		  	$detachment = $row['detachment'];
  			$leader_id = $row['leader_id'];
  	}
  	
 	if($leader_id != 0){
 		$result = $this->db->Query("SELECT CONCAT(r.shortname, ' ', m.last_name) AS name FROM rudi_unit_members AS m LEFT OUTER JOIN rudi_ranks AS r ON r.rank_id = m.rank_id WHERE m.member_id = '$leader_id' LIMIT 1");
	    $row = $this->db->FetchRow($result);
	    
		$leader->name = $row['name'];
		$leader->leader_id = $leader_id; 	
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
      ."WHERE m.member_id = %d ", 
      (int)$id);
      
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
      ."WHERE m.member_id = %d ", 
      (int)$id);
      
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
      ."WHERE m.squad_id = %d ", 
      (int)$id);
      
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
      ."WHERE t.team_id = %d ", 
	  (int)$id);
      
    $result = $this->db->Query($query);
    $data = $this->db->FetchObject($result,'Soldier');
    
    return $data;
  }
  /**
   * RUDI_Core::printRoster()
   *
   * @param int $unit_id
   * @param int $leader_id
   */  
  public function printRoster($unit_id, $leader_id){
  	$num = 0;
		foreach($this->data as $member){
			if($member->unit_id == $unit_id && $member->status_id < 3){
				decho($member);
			 	if($num%2==0){ 
					echo "<tr>";
   				}
				else { 
		  			echo '<tr class="high">';
				}
 ?>
          <!-- Rank -->
          <td class="roster">
          	<?php 
			  	if(file_exists("modules/rudi/images/ranks/tiny/{$member->rank_short}.png")){
          		   	echo "<img src=\"modules/rudi/images/ranks/tiny/{$member->rank_short}.png\" alt=\"{$member->rank_short}\" />";       	
          		}else{
          			//echo $member->rank_short;       		
          		}
		  	?>
  		  </td>
          <!-- Name -->
          <td class="roster"><a class="rosterlink" href="?load=rudi&amp;profile=<?php echo $member->member_id ?>"><?php echo $member->rank_long . ' ' . $member->first_name . ' ' . $member->last_name; ?></a></td>
            <!-- Roles -->
            <td class="roster">
            <?php echo $member->role_name; ?>
            <?php
            /*
            decho(count($member->Roles) . ' roles attached to: ' . $member->last_name);
            for($role = 0; $role < count($member->Roles); ++$role)
            {            	
				if($member->Roles[$role]->role_name)
				{
					//decho($role . " = (" . $member->Roles[$role]->role_name . ")");
					
						echo $member->Roles[$role]->role_name;
						if($role < count($member->Roles) - 1) echo ', ';
					
					//echo '&nbsp;';
				}           		
			} */
            ?> 
            </td>
          <!-- Weapon -->        
          <td class="roster"><?php echo $member->weapon_model; ?></td>
          <!-- Status -->
          <td class="roster"><?php echo $member->status; ?></td>
        </tr>
<?php		$num++;	
			}
									
		} 
  }
  
   /**
   * RUDI_Core::printReserves()
   *
   */  
  public function printReserves(){
  	$num = 0;
		foreach($this->data as $member){
			if($member->status_id == 3 || $member->unit_id == RUDI_ROSTER_RESERVES){
				decho($member);
				
				if($num == 0)
					echo "<tr><th colspan=\"5\">Reserves</th></tr>";
				
				if($num%2==0){ 
					echo "<tr>";
   				}
				else { 
		  			echo '<tr class="high">';
				}
 ?>
          <!-- Rank -->
          <td class="roster">
          	<?php 
			  	if(file_exists("modules/rudi/images/ranks/tiny/{$member->rank_short}.png")){
          		   	echo "<img src=\"modules/rudi/images/ranks/tiny/{$member->rank_short}.png\" alt=\"{$member->rank_short}\" />";       	
          		}else{
          			//echo $member->rank_short;       		
          		}
		  	?>
  		  </td>
          <!-- Name -->
          <td class="roster"><a class="rosterlink" href="?load=rudi&amp;profile=<?php echo $member->member_id ?>"><?php echo $member->rank_long . ' ' . $member->first_name . ' ' . $member->last_name; ?></a></td>
            <!-- Roles -->
            <td class="roster">
            <?php echo $member->role_name; ?>
            <?php
            /*
            decho(count($member->Roles) . ' roles attached to: ' . $member->last_name);
            for($role = 0; $role < count($member->Roles); ++$role)
            {            	
				if($member->Roles[$role]->role_name)
				{
					//decho($role . " = (" . $member->Roles[$role]->role_name . ")");
					
						echo $member->Roles[$role]->role_name;
						if($role < count($member->Roles) - 1) echo ', ';
					
					//echo '&nbsp;';
				}           		
			} */
            ?> 
            </td>
          <!-- Weapon -->        
          <td class="roster"><?php echo $member->weapon_model; ?></td>
          <!-- Status -->
          <td class="roster"><?php echo $member->status; ?></td>
        </tr>
<?php		$num++;	
			}
									
		}	
  }
  
 /**
   * RUDI_Core::printPastRoster()
   *
   */  
  public function printPastRoster(){
  	decho($this->data);
  	$num=0;
  			foreach($this->data as $member){
			if($member->status_id >= 4){
				decho($member);
?>
<?php 	if($num%2==0){ 
			echo "<tr>";
   		}
		else { 
		  	echo '<tr class="high">';
		}
 ?>
          <!-- Rank -->
          <td class="roster">
<?php 
			  	if(file_exists("modules/rudi/images/ranks/tiny/{$member->rank_short}.png")){
          		   	echo "<img src=\"modules/rudi/images/ranks/tiny/{$member->rank_short}.png\" alt=\"{$member->rank_short}\" />";       	
          		}else{
          			//echo $member->rank_short;       		
          		}
?>
  		  </td>
          <!-- Name -->
          <td><a class="rosterlink" href="?load=rudi&amp;profile=<?php echo $member->member_id ?>"><?php echo $member->rank_long . ' ' . $member->first_name . ' ' . $member->last_name; ?></a></td>
            <!-- Roles -->
            <td class="roster">
            <?php echo $member->role_name; ?>
<?php
           /* decho(count($member->Roles) . ' roles attached to: ' . $member->last_name);
            for($role = 0; $role < count($member->Roles); ++$role)
            {            	
				if($member->Roles[$role]->role_name)
				{
					//decho($role . " = (" . $member->Roles[$role]->role_name . ")");
					
						echo $member->Roles[$role]->role_name;
						if($role < count($member->Roles) - 1) echo ', ';
					
					//echo '&nbsp;';
				}           		
			} */
?> 
            </td>
          <!-- Weapon -->        
          <td class="roster"><?php echo $this->getDiffTime($member->date_enlisted, $member->date_discharged); ?></td>
          <!-- Status -->
          <td class="roster"><?php echo $member->status; ?></td>
        </tr>
<?php
			$num++;
			}
		
		}  
  }
  /**
   * RUDI_Core::displayUnitsRec()
   *
   * @param int $unit_id
   */
  public function displayUnitsRec($unit_id){
	    $result = $this->db->Query("SELECT * FROM `rudi_combat_units` WHERE `detachment` = '$unit_id' ORDER BY `weight`");
	    $row = $this->db->FetchObject($result,'UnitInfo');
	 	foreach($row as $unit){	
	 		$num = 0;
	 		$check = $this->db->Query("SELECT `member_id` FROM `rudi_unit_members` WHERE `cunit_id` = '$unit->unit_id' AND `date_discharged` IS NULL LIMIT 1");
	 		$num = $this->db->Rows($check);
	 		if($num >= 1 && $unit->unit_id != RUDI_ROSTER_RESERVES){
	 			echo "<tr><th colspan=\"5\">{$unit->name} : {$unit->callsign}</th></tr>";
				$this->printRoster($unit->unit_id, $unit->leader_id);   	 		
	 		}
			$this->displayUnitsRec($unit->unit_id);		 
		}
  }
 
  public function Update($query_t = RUDI_PROFILE_BIG)
  {
  	decho(get_class($this) . "::" . __FUNCTION__ . "($query_t)");
    $id = NULL;
    if(isset($_GET['profile']))
    {
      $id = addslashes($_GET['profile']);
      decho("Update() Profile ID: $id");
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
          ."m.primary_mos, "
          ."m.points, "
          ."m.drillcount, "
          ."m.attendcount, "
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
          ."ro.role_id, "
          ."ro.name AS role_name, "
          ."w.weapon_id, "
          ."w.manufacturer AS weapon_manufacturer, "
          ."w.model AS weapon_model, "
          ."w2.weapon_id, "
          ."w2.manufacturer AS weapon2_manufacturer, "
          ."w2.model AS weapon2_model, "
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
            ."LEFT OUTER JOIN rudi_weapons AS w2 ON w2.weapon_id = m.weapon2_id "
            ."LEFT OUTER JOIN rudi_roles AS ro ON ro.role_id = m.role_id "
            ."LEFT OUTER JOIN rudi_combat_units AS u ON u.unit_id = m.cunit_id "
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
          ."m.date_promotion, "
          ."m.date_enlisted, "
          ."m.date_discharged, "
          ."m.primary_mos, "
          ."r.rank_id, "
          ."r.image AS rank_image, "
          ."r.longname AS rank_long, "
          ."r.shortname AS rank_short, "
          ."r.weight AS rank_weight, "
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
          ."ro.role_id, "
          ."ro.name AS role_name, "
          ."w.weapon_id, "
          ."w.manufacturer AS weapon_manufacturer, "
          ."w.model AS weapon_model, "
  
          ."CONCAT(m.last_name, \", \", m.first_name) AS name, "
          ."CONCAT(w.manufacturer, \" \", w.model) as weapon_name "
          
        ."FROM rudi_unit_members AS m "
            ."LEFT OUTER JOIN rudi_weapons AS w ON w.weapon_id = m.weapon_id "
            ."LEFT OUTER JOIN rudi_roles AS ro ON ro.role_id = m.role_id "
            ."LEFT OUTER JOIN rudi_combat_units AS u ON u.unit_id = m.cunit_id "
            ."LEFT OUTER JOIN rudi_squads AS s ON s.squad_id = m.squad_id "
            ."LEFT OUTER JOIN rudi_teams AS t ON t.team_id = m.team_id "
            ."LEFT OUTER JOIN rudi_platoons AS p ON p.platoon_id = m.platoon_id "
            ."LEFT OUTER JOIN rudi_ranks AS r ON r.rank_id = m.rank_id "
            ."LEFT OUTER JOIN rudi_statuses AS st ON st.status_id = m.status_id ";
    }                                        
        
    if(!is_null($id))
    {
      $sql .= "WHERE m.member_id = " . (int)$id . " ";  
    }
          
    $sql .= "ORDER BY r.weight DESC , m.date_promotion ASC, m.date_enlisted ASC";          
    $result = $this->db->Query($sql);
    $count = 0;
    
    $row = $this->db->FetchObject($result,'Soldier');

    foreach($row as $member)
    {
      $count = $member->member_id;
      $this->data[$member->member_id] = $member;
    /*  $this->data[$count]->Roles = $this->getRoles($member->member_id,$member->rank_id);
      if(is_object($this->data[$count]->Roles))
	  {
	  	$this->data[$count]->Roles = array((object)$nothing);
	  } */
	  
      if($query_t != RUDI_PROFILE_SMALL)
      {
        $this->data[$count]->service_record = $this->getServiceRecord($member->member_id);
        $this->data[$count]->award_record = $this->getAwardRecord($member->member_id);
        $this->data[$count]->combat_record = $this->getCombatRecord($member->member_id);
        //$this->data[$count]->superior_next = $this->getSuperiorTrue($member->member_id);
		$this->data[$count]->superior = $this->getSuperior($member->member_id);
		        $this->data[$count]->superior->unit = $this->getSuperiorUnit($member->unit_id);
        $this->data[$count]->superior->platoon = $this->getSuperiorPlatoon($member->platoon_id);
        $this->data[$count]->superior->squad = $this->getSuperiorSquad($member->squad_id);
        $this->data[$count]->superior->team = $this->getSuperiorTeam($member->team_id);
        $this->data[$count]->superior_next = $this->getSuperiorTrue($member->member_id);                 
      }
      $count++;      
    } 

    return $this->data;
  }
  
  protected function getAwards()
  {
    $query = "SELECT a.award_id, a.image, a.name, a.description, a.class_id, c.name AS class_name "
      ."FROM rudi_awards AS a "
      ."LEFT OUTER JOIN rudi_award_classes AS c ON c.class_id = a.class_id "
      ."ORDER BY a.weight, c.class_id, a.award_id ASC";
    $result = $this->db->Query($query);
    $row = $this->db->FetchObject($result,'Award');
    return $row;  
  }
  
  protected function getAwardClasses()
  {
    $query = "SELECT class_id, name FROM rudi_award_classes";
    $result = $this->db->Query($query);
    $row = $this->db->FetchObject($result,'AwardClass');
    return $row;
  }
  
  protected function getWeapons($order = "")
  {
    $query = "SELECT weapon_id, manufacturer, model, role, caliber FROM rudi_weapons";
    $query = $query ." ". $order;
    $result = $this->db->Query($query);
    $row = $this->db->Fetch($result);
    return $row;
  }
  
  
  protected function getRanks()
  {
    $query = "SELECT rank_id, shortname, longname, image FROM rudi_ranks WHERE active = 1 ORDER BY weight DESC";
    $result = $this->db->Query($query);
    $row = $this->db->FetchObject($result,'Rank');
    
    return $row;  
  }  
/*
  protected function getDrills($id = NULL)
  {
    if(!is_null($id))
    {
      $query = sprintf("SELECT rd.drill_id, rd.date, rd.news, rd.notes, dr.performance, dr.excusal, dr.excusal_reason, dr.initiative, m.first_name, m.last_name FROM rudi_drills AS rd  
      LEFT OUTER JOIN rudi_drills_record AS dr ON dr.drill_id = rd.drill_id 
      LEFT OUTER JOIN rudi_unit_members AS m ON m.member_id = dr.member_id 
      LEFT OUTER JOIN rudi_statuses AS st ON st.status_id = m.status_id 
      WHERE rd.drill_id = %d ORDER BY date DESC",
	  (int)$id);
    }
    else
    {
      $query = "SELECT * FROM rudi_drills ORDER BY date DESC";      
    }
    
    $result = $this->db->Query($query);      
   	$row = $this->db->FetchObject($result,'Drill');
    
    return $row;  
  }
*/

}

?>
