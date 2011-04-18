<?php 
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler & Evan O'Connell
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
 
session_start();
 
include '../include/debug.php';
include '../include/config.php'; 
include '../include/sql.class.php';
include '../include/functions.php';

$db = new Bayonet_SQL();
$db->Connect(
  $config['sql']['hostname'],
  $config['sql']['username'],
  $config['sql']['password']
  );
$db->Select_db($config['sql']['database']);

//$config['logs']['dir'] = "../logs/";

include 'header.php';

 
  if(!defined("MODULE_FILE"))
  {
    //die("Access denied.");
  }
  
  define("ADMIN_FILE",'admin_file');
  include 'admin_functions.php';  
  
  if(isset($_GET['op']) && $_GET['op'] == 'logout')
  {
    logout();
  }
  
  if(login())
  {
    //this is so dirty...  sigh.
    if(is_loggedin())
    {
	
    	//GET ADMIN USER INFO - DEFINE IMPORTANT INFO
    	$username = $_SESSION['username'];
    	$result = $db->Query("SELECT user_id, level FROM bayonet_users WHERE username = '$username' LIMIT 1");
    	$row = $db->FetchRow($result);
    	define("ADMIN_USERNAME", $username);
    	define("ADMIN_ID", $row['user_id']);
    	define("ADMIN_LEVEL", $row['level']);
    	
    	
   		if(isset($_GET['op'])){
   		?>
    		<script type="text/javascript">
					window.location = window.location+"#operation";
			</script>
	  <?php   	
    	}
      ?>

 <center>
 <div class="wrapper">     
 
<table width="100%">
	<tr>
		<td><a href="index.php"><img src="images/bayonet_logo.jpg" alt="bayonet online web admin" /></a></td>
		<td style="text-align:right">
			<a href="?op=settings">Account Settings</a> &nbsp;|&nbsp;
			<a href="?op=logout">Logout, <?php echo ADMIN_USERNAME; ?></a>
		</td>
	</tr>
</table>

<br />

  	<fieldset>
  	<legend>Administration Menu:</legend>
      <?php 
        $th = array('Administration Menu','');
        $td = array(
          LinkInternal('<img src="images/modules.png" /><br />Modules','?op=modules'),
          LinkInternal('<img src="images/blocks.png" /><br />Blocks','?op=blocks'),
          LinkInternal('<img src="images/navigation.png" /><br />Navigation','?op=navigation'),
		  LinkInternal('<img src="images/users_two.png" /><br />Edit Admins','?op=admins'),
		  LinkInternal('<img src="images/announcement.png" /><br />Announcements','?op=announcements')      
        );
        
        //render administration table
        CompileAdmin($th,$td);
      ?>
 	</fieldset>
<br />
  	<fieldset>
  	<legend>Module Administration:</legend>
      <?php 
        $th = array('Module Administration','');
        $td = array(
          LinkInternal('<img src="images/editpage.png" /><br />Pages','?op=pages'),
          LinkInternal('<img src="images/image.png" /><br />News Reel','?op=newsreel'),
          LinkInternal('<img src="images/news.png" /><br />News','?op=news'),
          LinkInternal('<img src="images/calendar.png" /><br />Calendar','?op=calendar'),
          LinkInternal('<img src="images/box_download.png" /><br />Downloads', '?op=downloads'),
		  LinkInternal('<img src="images/rudi.png" /><br />RUDI','?op=rudi'),
		  LinkInternal('<img src="images/adjutant.png" /><br />Adjutant','?op=adjutant')       
        );
        
        //render administration table
        CompileAdmin($th,$td);
      ?>
 	</fieldset>

<br />
<a name="operation"></a>
<div style="text-align:center"><?php include 'operation.php' ?></div>

  </div>
<?php 
$phpversion = preg_replace('/[a-z-]/', '', phpversion());
$mtime = explode(' ', microtime());
$totaltime = $mtime[0] + $mtime[1] - $starttime;
$debug_output = sprintf("Page generated in %.3f seconds | Memory: real(%.3fmb) peak(%.3fmb) | PHP: %s<br/>Queries: %d | Fetches: %d<br/>\n",
                $totaltime, ((float)memory_get_usage()/1024/1024), ((float)memory_get_peak_usage()/1024/1024), $phpversion, $db_queries, $db_fetches);
?>
  </center>

<br />
<?php echo $config['product']['name'] . ' ' . $config['product']['version'] . ' ' . $config['product']['release'] ?><br />
<?php echo $config['product']['copyright']; ?><br />
<?php if($config['debug']) echo $debug_output ?><br />
<?php
 if($config['debug']['enabled']){ 
	logQueueFlush();
 } 
?> 
<?php 
    }
  }
    
?>