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
 
/**
 * Note to anyone feeling the need to edit this file...
 * You MUST declare $db as global inside your functions in order access MySQL from here.
 */
 
function EditAnnouncements()
{
   global $db;
  
  if(isset($_POST['announcementprocessed']))
  {
    //Secure our data to prevent injection attacks.
    $title = addslashes($_POST['title']);
    $text = addslashes($_POST['text']);
    if(empty($title) || empty($text))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
          
    //Update the database with the new data.
    $db->Query("UPDATE bayonet_announcements SET title = '$title', text = '$text' WHERE announcement_id = 0");
    echo "Announcement, '$title', has been edited.\n <br /><br /> Please wait while you are redirected. <br /><br /> 
			<a href=\"?op=announcements\">Click here if you don't feel like waiting.</a>";
    
    // 3 second redirect to go back to the edit page
    echo "<meta http-equiv=\"Refresh\" content=\"3;url=?op=announcements\">";
    
    //die, because we have completed what we wanted to do.
    return;
  }
  
  
  //Grab the page from the database according to the $article_id passed to the function.
  $result = $db->Query("SELECT title,text FROM bayonet_announcements WHERE announcement_id = 0");
  while(($row = $db->Fetch($result))!=false)
  {
    //We only want one row, so we don't have to $article[]...  No foreach necessary.
    $announcement = $row; 
  } 
  ?>
  	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  	<table>
  		<tr><td>Announcement Title: <input type="text" name="title" value="<?php echo $announcement['title'] ?>" maxlength="50" size="30" /> </td></tr>
  		<tr><td> <textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $announcement['text'] ?></textarea> </td></tr>
  		<tr><td> <input type="submit" name="announcementprocessed" value="Submit Changes" /> </td></tr>
	</table>
  	</form>
  <?php
}
?>