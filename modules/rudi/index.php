<link rel="stylesheet" type="text/css" href="modules/rudi/includes/rudi.css" media="screen"/>
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

include 'header.php';
//include 'includes/debug.php';
//require 'includes/sql.class.php';
include_once 'includes/common.class.php';
include_once 'includes/drills.class.php';
include_once 'includes/information.class.php';
define('BLOCK_RIGHT_DISABLE', true);

OpenContent();
	echo "<div class=\"contentHeading\">RUDI: Realism Unit Data Interface</div>";
	echo "<div class=\"content\">";
class RUDI_Gateway extends RUDI_Common
{
  protected $awards, $ranks, $drills;
  
  public function __construct()
  {
  	decho("Constructing " . get_class($this));
    parent::__construct();
    
    if(isset($_GET['admin']))
    {
      define('BLOCK_RIGHT_DISABLE','block_right_disable');
      include 'admin/index.php';
      return;
    }
    
    if(isset($_GET['info']))
    {
    	$info = new RUDI_Information();
    	OpenTable();
    	echo "<tr><td>\n";
    	include 'views/view.information.php';
    	echo "</tr></td>";
    	CloseTable();
    	return;
    }
    
    if(isset($_GET['profile']))
    {
      $this->Update();
      
      OpenTable();
      echo "<tr><td>\n";
      include 'views/view.profile.php';
      echo "</td></tr>";
      CloseTable();
      return;
    }
    elseif(isset($_GET['show']))
    {
      OpenTable();
      echo "<tr><td>\n";
      switch($_GET['show'])
      {
        case 'awards':
          $this->awards = $this->getAwards();
          include 'views/view.awards.php';
          break;
        case 'ranks':
          $this->ranks = $this->getRanks();
          include 'views/view.ranks.php';
          break;
        case 'drills':
          //$this->drills = $this->getDrills($_GET['id']);
          $drills = new RUDI_Drills($_GET['id']);
          include 'views/view.drills.php';
          break; 
		case 'points':
			$this->Update();
			include 'views/view.points.php';
			break;
		case 'weapons':
          	include 'views/view.weapons.php';
			break;    
      }
      echo "</td></tr>";
      CloseTable();
      return;
    }
    else
    {
      $this->Update(RUDI_PROFILE_SMALL);
      $stats = $this->getCumulativeStats();
      
      OpenTable();
      echo "<tr><td>\n"; 
      include 'views/view.roster.php';
      echo "</td></tr>";
      CloseTable();
      return;
    }
  }
  
  public function __destruct()
  {
  	decho("Destructing " . get_class($this));
  }
}

ob_start();
$rudi = new RUDI_Gateway();
ob_flush();
	echo "</div>";
	echo "</div>";
CloseContent();

//include 'footer.php';
//decho($test->foo[0]->member_id);
//$test1 = new Test();
//$test2 = new Test();
?>
