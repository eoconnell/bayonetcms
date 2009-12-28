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

function ListPages($pid = NULL)
{ 
  global $db;
  $result = $db->Query("SELECT `page_id`,`title` FROM `bayonet_pages`");
  $pages = $db->Fetch($result);
  
  echo "<table class=\"panelitems\" width=\"100%\" cellspacing=\"0\">";
  	
  ?>
  <tr>
  	<td style="text-align:center; text-overflow:ellipsis; overflow:hidden; background-color:#dfe4df; border-bottom: 1px solid #848484;">
		<?php echo LinkInternal('<img src="images/add.png" />&nbsp;Create New Page','?op=pages&create=true'); ?>
  	</td>
  </tr>
  	
  <?php

  if(count($pages)==0)
  {
  	echo "<tr><td>No Pages Found.<br /></td></tr></table>";
  	return;
  }
 
  foreach($pages as $page)
  {
  	$edit = false;
  	 if($_GET['edit'] == $page['page_id']){
  	 	$edit = true;
    	echo '<tr class="highlight">';
   	 }else 
   	 	echo '<tr>';
   	 ?>	
   	 
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden;">
		<a href="?op=pages&edit=<?php echo $page['page_id']?>">
			<img src="images/page.png" />
			<?php echo $page['title']; ?>
		</a>
  	 </td>
	</tr>
<?php		
  }	  
  	echo "</table>";
 	
}

function NewPage()
{
  global $db;
  if(isset($_POST['processed']))
  {
    //Secure our data to prevent injection attacks.
    $title = addslashes($_POST['title']);
    $text = addslashes($_POST['text']);
    if(empty($title))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
    
    //Update the database with the new data.
    $db->Query("INSERT INTO `bayonet_pages` (`page_id` ,`author_id` ,`page_created` ,`title` ,`text`)VALUES (NULL , '0',CURRENT_TIMESTAMP , '$title', '$text')");
    
    echo "New page, '$title', has been added.\n";
    PageRedirect(2, "?op=pages");
    //die, because we have completed what we wanted to do.
    return;
  }
     
  ?>
  <h3>Add New Page</h3>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table>
  <tr><th>Title:</th><td><input type="text" name="title" value="" /></td></tr>
  <tr><th>Text:</th><td><textarea id="markItUp" rows="30" cols="80" name="text"></textarea></td></tr>
  <tr><th colspan="2"><input type="submit" name="processed" value="Submit" /></th></tr>
  </table>
  </form>
  <?php
}

function EditPage($page_id)
{
  global $db;
  $page_id = addslashes($page_id);  
  // If the user has submitted, then process their request.
  if(isset($_POST['processed']))
  {
    //Secure our data to prevent injection attacks.
    $title = addslashes($_POST['title']);
    $text = addslashes($_POST['text']);
    if(empty($title))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
        
    //Update the database with the new data.
    $db->Query("UPDATE `bayonet_pages` SET `title` = '$title', `text` = '$text' WHERE `page_id` = '$page_id'");
    echo "Page, '$title', has been edited.\n";
    PageRedirect(2, "?op=pages&edit={$page_id}");
    //die, because we have completed what we wanted to do.
    return;
  }
  
  //Grab the page from the database according to the $article_id passed to the function.
  $result = $db->Query("SELECT `title`, `text` FROM `bayonet_pages` WHERE `page_id` = '$page_id' LIMIT 1");
  $page = $db->FetchRow($result);  
  ?>
  	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  	<table>
  		<tr>
		  <td colspan="2">
		  	<input type="submit" name="processed" value="Submit Changes" />
			<?php echo LinkInternal('<img src="images/view.png" />&nbsp;View this Page','../index.php?load=page&id='.$page_id.'" target=\"blank'); ?>
			<?php echo LinkInternal("<img src=\"images/cancel.png\" /> Delete This Page","?op=pages&delete={$page_id}"); ?>
		  </td>
	    </tr>
  		<tr>
		  <th>Title:</th>
		  <td><input type="text" name="title" value="<?php echo $page['title'] ?>" maxlength="50" size="30" /></td>
	    </tr>		  		
  		<tr>
	      <th>Text:</th>
		  <td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $page['text'] ?></textarea></td>
	    </tr>
	</table>
  	</form>
  <?php
}

function DeletePage($page_id)
{
  global $db;
  
  $result = $db->Query("SELECT title FROM bayonet_pages WHERE page_id = '$page_id' LIMIT 1");
  $page = $db->FetchRow($result);
  
  if(isset($_POST['proceed']))
  {
    echo "Page '{$page['title']}', was deleted.";
    $db->Query("DELETE FROM bayonet_pages WHERE page_id = '$page_id' LIMIT 1");
    PageRedirect(2, "?op=pages&edit={$page_id}");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of page: '{$page['title']}'";
    PageRedirect(2, "?op=pages&edit={$page_id}");
    return;
  }
  if($page_id == 1){
  	echo "You can not delete the home page.";
  	PageRedirect(2, "?op=pages&edit={$page_id}"); 
	return; 
  }
  
  ?>

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <table>
  <th>Are you <u>SURE</u> you want to delete the page titled: '<?php echo $page['title'];?>'?<br />All articles attached to this page will be deleted as well.</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
  </table>
  </form>
  <?php
}

?> 