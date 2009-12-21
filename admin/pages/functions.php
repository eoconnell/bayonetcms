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

function ListArticles($pageid){
  
  global $db;
  $result = $db->Query("SELECT article_id,title FROM bayonet_articles WHERE `page_id` = $pageid ORDER BY `weight`");
  while(($row = $db->Fetch($result))!=false)
  {
    $articles[] = $row;
  }
  
  	echo "<table class=\"panelitems\" width=\"100%\" cellspacing=\"0\">";
  	
  	?>
	<tr>
 	 <td colspan="3" style="text-align:center; text-overflow:ellipsis; overflow:hidden; background-color:#dfe4df; border-bottom: 1px solid #848484;">
		<?php echo LinkInternal('<img src="images/add.png" />&nbsp;Add New Article','?op=pages&edit='.$pageid.'&newarticle=true'); ?>
  	 </td>
	</tr>
  	
  	<?php

  if(count($articles)==0){
  	echo "<tr><td>No Articles Found.<br /></td></tr></table>";
  	return;
  }
  foreach($articles as $article)
  {
  	 if($_GET['aid'] == $article['article_id'])
    	echo '<tr class="highlight">';
   	 else 
   	 	echo '<tr>';
   	 ?>	
   	 
 	 <td>^</td>
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden;">
		<a href="?op=pages&edit=<?php echo $pageid; ?>&aid=<?php echo $article['article_id']?>"><?php echo $article['title']; ?></a>
  	 </td>
 	 <td>v</td>	
	</tr>
	
	<?php
  }
  
  	echo "</table>";
  

	
}

function NewArticle($page_id)
{
  global $db;
  if(isset($_POST['newarticleprocessed']))
  {
    //Secure our data to prevent injection attacks.
    $title = addslashes($_POST['title']);
    $text = addslashes($_POST['text']);
    if(empty($title) || empty($text))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
       $weight = 0;
       	$result = $db->Query("SELECT * FROM `bayonet_articles` WHERE `page_id` = $page_id ORDER BY `weight` DESC LIMIT 1");
  		while(($row = $db->Fetch($result))!=false)
  		{
    		$weight = $row['weight'];
  		}
       $weight++;
    
    //Update the database with the new data.
    $db->Query("INSERT INTO `bayonet_articles` (`article_id` ,`page_id` ,`title` ,`text`, `weight`)VALUES (NULL , $page_id, '$title', '$text', '$weight')");
    echo "New article, '$title', has been added.\n";
    PageRedirect(2, "?op=pages&edit={$_GET['edit']}");
    //die, because we have completed what we wanted to do.
    return;
  }
     
  ?>
  <h3>Add New Article</h3>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table>
  <tr><td>Title: </td><td><input type="text" name="title" value="" /></td></tr>
  <tr><td colspan="2"><textarea id="markItUp" rows="30" cols="80" name="text"></textarea></td>
  <tr><th colspan="2"><input type="submit" name="newarticleprocessed" value="Submit" /></th></tr>
  </table>
  </form>
  <?php
}

function EditArticle($article_id){

  global $db;
  
  if(isset($_POST['articleprocessed']))
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
    $db->Query("UPDATE bayonet_articles SET title = '$title', text = '$text' WHERE article_id = '$article_id'");
    echo "Article, '$title', has been edited.\n <br /><br /> Please wait while you are redirected. <br /><br /> 
			<a href=\"?op=pages&edit=".$_GET['edit']."&aid=".$article_id."\">Click here if you don't feel like waiting.</a>";
    
    //echo "<meta http-equiv=\"Refresh\" content=\"3;url=?op=pages&edit=".$_GET['edit']."&aid=".$article_id."\">";
   	PageRedirect(2,"?op=pages&edit={$_GET['edit']}&aid={$article_id}");
    
    //die, because we have completed what we wanted to do.
    return;
  }
  
  
  //Grab the page from the database according to the $article_id passed to the function.
  $result = $db->Query("SELECT title,text FROM bayonet_articles WHERE article_id = '$article_id'");
  while(($row = $db->Fetch($result))!=false)
  {
    //We only want one row, so we don't have to $article[]...  No foreach necessary.
    $article = $row; 
  } 
  
  
  ?>
  	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  	<table>
  		<tr><td>
		  		<input type="text" name="title" value="<?php echo $article['title'] ?>" maxlength="50" size="30" />
		  		<input type="submit" name="articleprocessed" value="Submit Changes" />
		  		<a href="?op=pages&edit=<?php echo $_GET['edit']; ?>&delarticle=<?php echo $article_id; ?>"><img src="images/cancel.png" /> Delete This Article</a>
	  	</td></tr>
  		<tr><td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $article['text'] ?></textarea></td></tr>
	</table>
  	</form>
  <?php
}

function DeleteArticle($article_id)
{
  global $db;
  
  $result = $db->Query("SELECT title FROM bayonet_articles WHERE article_id = '$article_id'");
  $article = $db->Fetch($result);
  
  if(isset($_POST['proceed']))
  {
    echo "Article '{$article['title']}', was deleted.";
    $db->Query("DELETE FROM bayonet_articles WHERE article_id = '$article_id' LIMIT 1");
    PageRedirect(2, "?op=pages");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of article: '{$article['title']}'";
    PageRedirect(2, "?op=pages&edit={$_GET['edit']}&aid={$article_id}");
    return;
  }  
  ?>
  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <table>
  <th>Are you SURE you want to delete the article titled: '<?php echo $article['title']?>'?</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
  </table>
  </form>
  <?php
}

function ListPages($pid = NULL)
{ 
  global $db;
  $result = $db->Query("SELECT page_id,title FROM bayonet_pages");
  while(($row = $db->Fetch($result))!=false)
  {
    $pages[] = $row;
  }
  
  	echo "<table class=\"panelitems\" width=\"100%\" cellspacing=\"0\">";
  	
  	?>
	<tr>
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden; background-color:#dfe4df; border-bottom: 1px solid #848484;">
		<?php echo LinkInternal('<img src="images/add.png" />&nbsp;Create New Page','?op=pages&create=true'); ?>
  	 </td>
	</tr>
  	
  	<?php

  if(count($pages)==0){
  	echo "<tr><td>No Pages Found.<br /></td></tr></table>";
  	return;
  }
 
  foreach($pages as $page)
  {
  	 if($pid == $page['page_id'])
    	echo '<tr class="highlight">';
   	 else 
   	 	echo '<tr>';
   	 ?>	
   	 
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden;">
		<a href="?op=pages&edit=<?php echo $page['page_id']?>"><?php echo $page['title']; ?></a>
  	 </td>
	</tr>
	
	<?php
  }
  
 	?>
<!--
 		<tr style="vertical-align:bottom; background-color:green; text-overflow:ellipsis; overflow:hidden;">
 		<td>
			<table class="panelitems">
				<tr><td>
				<?php echo LinkInternal('<img src="images/add.png" />&nbsp;Create New Page','?op=pages&create=true'); ?> <br />
				<?php echo LinkInternal('<img src="images/view.gif" />&nbsp;View this Page','../index.php?load=page&id='.$page_id); ?> <br />
	   			<?php echo LinkInternal('<img src="images/cancel.png" />&nbsp;Delete this Page','?op=pages&delete='.$page_id); ?> <br />
	   			</td></tr>
			</table>
		<td>
		</tr> -->
		

	<tr>
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden;">
		<?php echo LinkInternal('<img src="images/view.gif" />&nbsp;View this Page','../index.php?load=page&id='.$pid); ?>
  	 </td>
	</tr>
	<tr>
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden;">
		<?php echo LinkInternal('<img src="images/cancel.png" />&nbsp;Delete this Page','?op=pages&delete='.$pid); ?>
  	 </td>
	</tr>
  	<?php
  
  	echo "</table>";
 	
}

function NewPage()
{
  global $db;
  if(isset($_POST['newpageprocessed']))
  {
    //Secure our data to prevent injection attacks.
    $title = addslashes($_POST['title']);
    if(empty($title))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
    
    //Update the database with the new data.
    $db->Query("INSERT INTO `bayonet_pages` (`page_id` ,`author_id` ,`page_created` ,`title` ,`text`)VALUES (NULL , '0',CURRENT_TIMESTAMP , '$title', '$text')");
    
    echo "New page, '$title', has been added.\n";
    //die, because we have completed what we wanted to do.
    return;
  }
     
  ?>
  <h3>Add New Page</h3>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table>
  <tr><th>Title</th><td><input type="text" name="title" value="" /></td></tr>
  <tr><th colspan="2"><input type="submit" name="newpageprocessed" value="Submit" /></th></tr>
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
    if(empty($title))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
        
    //Update the database with the new data.
    $db->Query("UPDATE bayonet_pages SET title = '$title' WHERE page_id = '$page_id'");
    echo "Page, '$title', has been edited.\n";
    //die, because we have completed what we wanted to do.
    return;
  }

?>  
   
   <table class="panel" width="100%" cellspacing="0">
   		<tr>
	       <td class="panel-none">
	       		<?php ListPages($page_id); ?>
		   </td>
  		   <td class="panel-shadow">
   				<?php ListArticles($page_id); ?>
		   </td>
		   <td class="panel-box">
<?php
    		//if article is set then EditArticle();
 		    $aid = $_GET['aid'];   
 		    
    		if($_GET['newarticle']){
    			NewArticle($page_id);	    		
    		}
    		else if(isset($_GET['delarticle'])){
    			$article_id = $_GET['delarticle'];
   				DeleteArticle($article_id);
   			}
    		else if($aid > 0){
  				EditArticle($aid);
   			}
	?>   			
   			</td>

  		</tr>
  </table>
  <?php
}

function DeletePage($page_id)
{
  global $db;
  
  $result = $db->Query("SELECT title FROM bayonet_pages WHERE page_id = '$page_id'");
  $page = $db->Fetch($result);
  
  if(isset($_POST['proceed']))
  {
    echo "Page '{$page['title']}', was deleted.";
    $db->Query("DELETE FROM bayonet_pages WHERE page_id = '$page_id' LIMIT 1");
    return;
  }
  if(isset($_POST['cancel']))
  {
    echo "User cancelled deletion of page: '{$page['title']}'";
    return;
  }
  if($page_id == 1){
  	echo "You can not delete the home page."; 
	return; 
  }
  
  ?>

  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  <table>
  <th>Are you <u>SURE</u> you want to delete the page titled: '<?php echo $page['title']?>'?<br />All articles attached to this page will be deleted as well.</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
  </table>
  </form>
  <?php
}

?> 