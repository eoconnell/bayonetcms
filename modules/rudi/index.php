<link rel="stylesheet" type="text/css" href="modules/rudi/includes/rudi.css" media="screen"/>
<?php
//include 'header.php';
//include 'includes/debug.php';
//require 'includes/sql.class.php';
include_once 'includes/common.class.php';
include_once 'includes/information.class.php';

OpenContent();
	echo "<div class=\"contentHeading\">RUDI: Realism Unit Data Interface</div>";
	echo "<div class=\"content\">";
class RUDI_Gateway extends RUDI_Common
{
  protected $awards, $ranks, $drills;
  
  public function __construct()
  {
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
          $this->drills = $this->getDrills($_GET['id']);
          include 'views/view.drills.php';
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