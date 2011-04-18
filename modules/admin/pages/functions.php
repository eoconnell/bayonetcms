<?php
/**
 * Bayonet Content Management System
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

 
/**
 * Note to anyone feeling the need to edit this file...
 * You MUST declare $db as global inside your functions in order access MySQL from here.
 */

function ListArticles($pageid){
  
  global $db;
  $result = $db->Query("SELECT article_id,title FROM bayonet_articles WHERE `page_id` = $pageid ORDER BY `weight`");
  $articles = $db->Fetch($result);
  
  	echo "<table class=\"cleartable\" width=\"100%\" cellspacing=\"0\">";

  if(count($articles)==0){
  	echo "<tr><td>There are no articles posted on this page.<br /></td></tr></table>";
  	return;
  }
  foreach($articles as $article)
  {
  	 if($_GET['aid'] == $article['article_id'])
    	echo '<tr style="background-color:#c1c1c1; height:30px;">';
   	 else 
   	 	echo '<tr style="height:30px;">';
   	 ?>	
   	 
 	 <td>^</td>
 	 <td style="text-align:center; text-overflow:ellipsis; overflow:hidden;">
		<a href="?load=admin&op=pages&edit=<?php echo $pageid; ?>&aid=<?php echo $article['article_id']?>"><?php echo $article['title']; ?></a>
  	 </td>
 	 <td>v</td>	
	</tr>
	
	<?php
  }
  
  	echo "</table>";
  

	
}

function EditArticle($article_id){

  global $db;
  //Grab the page from the database according to the $article_id passed to the function.
  // {{{ XXX: FIXME -- Needs to be re-written
  /*
  $result = $db->Query("SELECT title,text FROM bayonet_articles WHERE article_id = '$article_id'");
  while(($row = $db->Fetch($result))!=false)
  {
    //We only want one row, so we don't have to $article[]...  No foreach necessary.
    $article = $row; 
  }
  */
  // }}}
  ?>
  	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
  	<table class="cleartable">
  		<tr><td>
		  		<input type="text" name="title" value="<?php echo $article['title'] ?>" maxlength="50" size="30" />
		  		<input type="submit" name="processed" value="Submit Changes" />
	  	</td></tr>
  		<tr><td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $article['text'] ?></textarea></td></tr>
	</table>
  	</form>
  <?php
}

function ListPages($pid = NULL)
{
  global $db;
  $pages = $db->Query("SELECT page_id,title FROM bayonet_pages");

  echo 'Select page: <select id="pagenames" onchange="gotoEditPage(this.id)">';
  echo '<option value="0">-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-</option>';
  //echo "<table align=\"center\"><tr><th colspan=\"3\">Existing Pages</th></tr>";
  

  foreach($pages as $page)
  {
  	 if($pid == $page['page_id'])
    	echo "<option value=\"{$page['page_id']}\" selected>{$page['title']}</option>";
   	 else
   	 	echo "<option value=\"{$page['page_id']}\">{$page['title']}</option>";
  }
   echo '</select>';
 // echo "</table>";
}

function NewPage()
{
  global $db;
  if(isset($_POST['processed']))
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
    $db->Query("INSERT INTO bayonet_pages SET title = '$title', text = '$text'");
    echo "New page, '$title', has been added.\n";
    //die, because we have completed what we wanted to do.
    return;
  }
     
  ?>
  <h3>Add New Page</h3>
  <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
  <table>
  <tr><th>Title</th><td><input type="text" name="title" value="<?php echo $page['title'] ?>" /></td></tr>
  <tr><th>Text</th><td><textarea id="markItUp" rows="30" cols="80" name="text"><?php echo $page['text'] ?></textarea></td>
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
    if(empty($title) || empty($text))
    {
      echo "You must fill everything out before proceeding.";
      return;
    }
        
    //Update the database with the new data.
    $db->Query("UPDATE bayonet_pages SET title = '$title', text = '$text' WHERE page_id = '$page_id'");
    echo "Page, '$title', has been edited.\n";
    //die, because we have completed what we wanted to do.
    return;
  }

   $aid = $_GET['aid'];
?>  
   <table width="100%">
   		<tr>
   			<td><?php ListPages($page_id); ?></td>
			<td><?php echo LinkInternal('<img src="images/view.gif" />&nbsp;View this Page','?load=page&id='.$page_id); ?></td>
   			<td class="right"><?php echo LinkInternal('<img src="images/delete.gif" />&nbsp;Delete this Page','?load=admin&op=pages&delete='.$page_id); ?></td>
   		</tr>
   </table>
   <hr />
   <table class="cleartable" width="100%" style="height:95%;" cellspacing="0">
   		<tr>
		   <td style="vertical-align:top;">
   				<?php ListArticles($page_id); ?>
			</td>
			<td style="width:589px; vertical-align:top; border-left:1px solid #848484;">
   		<?php
    		//if article is set then EditArticle();
    		if($aid > 0){
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
  <th>Are you SURE you want to delete the page titled: '<?php echo $page['title']?>'?</th>
  <tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
  </table>
  </form>
  <?php
}

?> 
