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
 /*
  if(!defined("MODULE_FILE"))
  {
    die("Access denied.");
  }
  
  define("ADMIN_FILE",'admin_file');
  include 'admin_functions.php';  
  
  if($_GET['op'] == 'logout')
  {
    logout();
  }
  
 if(login())
  {
    //this is so dirty...  sigh.
    if(is_loggedin())
    {
      ?>          
      <!-- Add id="wrapper" for full height -->
      <table align="center" width="90%" >
      <tr><td><div style="text-align:right"><a href="?load=admin&op=logout">Logout, <?php echo $_SESSION['username']?></a></div></td></tr>
      <tr><td>

 <div class="maincontent">     
  	<fieldset>
  	<legend>Administrative Tools:</legend>
      <?php 
        $th = array('Blocks','Pages');
        $td = array(
          //LinkInternal('Blocks','?load=admin&op=blocks'),
          LinkInternal('<img src="images/editpage.png" /><br />Manage Pages','?load=admin&op=pages'),
          LinkInternal('<img src="images/navigation.png" /><br />Edit Navigation','?load=admin'),
          LinkInternal('<img src="images/announcement.png" /><br />Edit Announcements','?load=admin'),
          LinkInternal('<img src="images/calendar.png" /><br />Manage Events','?load=admin'),
          LinkInternal('<img src="images/photogallery.png" /><br />Manage Galleries', '?load=admin')
          
        );
        
        //render administration table
        CompileAdmin($th,$td);
      ?>
 	</fieldset>

      </td></tr>
      <tr><td><div style="text-align:center"><?php include 'operation.php' ?></div></td></tr>
            
      </table>
  </div>
      <?php )
    }
  } */
    
?>