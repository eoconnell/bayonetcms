<?php
//include 'header.php';
//include 'includes/debug.php';
//include 'includes/sql.class.php';
include 'includes/common.class.php';

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
    
    if(isset($_GET['profile']))
    {
      $this->Update();
      
      OpenTable();
      echo "<tr><th>RUDI</th></tr><tr><td>\n";      
      include 'views/view.profile.php';
      echo "</td></tr>";
      CloseTable();
      return;
    }
    elseif(isset($_GET['show']))
    {
      OpenTable();
      echo "<tr><th>RUDI</th></tr><tr><td>\n";
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
      decho($stats);
      
      OpenTable();
      echo "<tr><th>RUDI</th></tr><tr><td>\n";      
      include 'views/view.current.php';
      echo "</td></tr>";
      CloseTable();
      return;
    }
  }
}

ob_start();
$rudi = new RUDI_Gateway();
ob_flush();

//include 'footer.php';
//decho($test->foo[0]->member_id);
//$test1 = new Test();
//$test2 = new Test();
?>