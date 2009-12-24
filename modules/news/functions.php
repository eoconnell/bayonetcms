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
  * getNewsComments($id)
  * Function getting an array of comments for posted news
  * @param id - news_id cooresponding to `bayonet_news`
  * @return - associative array of comments
  */  
function getNewsComments($id){
	
	global $db;
	$result = $db->Query("SELECT c.comment_id, c.news_id, c.author_id, c.message, c.date, u.username AS author, u.avatar as avatar ".
                     "FROM `bayonet_news_comments` AS c ".
                     "LEFT OUTER JOIN `mybb_users` AS u ON u.uid = c.author_id ".
                     "WHERE c.news_id = '$id' ".
                     "ORDER BY date ASC");
	while(($row = $db->Fetch($result)) != false)
	{
	  $comments[] = $row;
	}
	
	$db->Free($result);
	
	return $comments;
}

 /**
  * displayComments($data)
  * Function that takes an array of comments and displays them in html
  * @param data - associative array of comments from the database
  */  
function displayComments($data){
	
	date_default_timezone_set("America/New_York");
	OpenTable();
	?>
	
	<div id="comments">
	<table width="100%">
		<tr>
			<td><h2>User Comments</h2></td>
			<td style="text-align:right"><a href="#add">Add Yours</a></td>
		</tr>
	</table>
	<ol class="comment_list parent">
	
	<?php
	foreach($data as $comment)
	{
	?>
		<li id="comment-<?php echo $comment['comment_id']; ?>">
			<div class="comment_wrap">
	
				<div class="comment_author">
					<?php
						if(!empty($comment['avatar'])){
							echo "<img src=\"{$comment['avatar']}\" height=\"80px\" />";					
						}else{
							echo "<img src=\"modules/news/images/avatar.png\" />";						
						}
					?>
					<p>
					<?php	
						if($comment['author_id']>0){
							echo "<a href=\"{$comment['author_id']}\">{$comment['author']}</a>";						
						}else{
							echo "Guest";						
						}
					?>
						
						<span><?php echo date('F jS', strtotime($comment['date'])); ?></span> 
					</p>
				</div>
				
				<div class="single_comment">
					<img src="modules/news/images/comment_arrow.png" class="comment_arrow" />
					<p> <?php echo BBCode($comment['message']); ?></p>
				
				</div>
				
			</div>		
		</li>	
		
	<?php			
	}
	echo "</ol>";
	
	commentForm();
	
	CloseTable();
}

 /**
  * getNumOfComments($id)
  * Function that gets the number of comments a news post has
  * @param id - news_id cooresponding to `bayonet_news`
  */  
function getNumOfComments($id){
	
	global $db;
	$result = $db->Query("SELECT `comment_id` FROM `bayonet_news_comments` WHERE `news_id` = '$id'");	
		
	return $db->Rows($result);;
}

 /**
  * getNumOfComments($id)
  * Function that gets the desired news from the database and returns it as an array
  * @param id - (optional) news_id cooresponding to `bayonet_news`
  */  
function getNews($id = NULL){

	global $db;
	$query = "SELECT n.news_id, n.title, n.message, n.date, n.category_id, u.username AS author, c.name AS catname, c.image AS catimage ".
                     "FROM `bayonet_news` AS n ".
                     "INNER JOIN `bayonet_news_categories` AS c ON c.category_id = n.category_id ".
                     "LEFT OUTER JOIN `mybb_users` AS u ON u.uid = n.author_id ";
 	if(isset($id)){
 		$query = $query."WHERE n.news_id = '$id' ";
	}else{
		$query = $query."ORDER BY date DESC";
		if($limit !=NULL){
			$query = $query." LIMIT '$limit'";		
		}
 	}
 		
	$result = $db->Query($query);
	while(($row = $db->Fetch($result)) != false)
	{
	  $data[] = $row;
	} 
	
	$db->Free($result);
	
	return $data;
}

 /**
  * displayNews($data)
  * Function that takes an array of news and displays it as html
  * @param data - associative array of news from the database
  */  
function displayNews($data){
	
	date_default_timezone_set("America/New_York");
	foreach($data as $news)
	{
		$numComments = getNumOfComments($news['news_id']);
		
		OpenTable(); ?>
	
			<div class="contentHeading">
					<table width="100%">
						<tr>
							<td style="text-align:left;"><?php echo $news['title']; ?></td>
							<td style="text-align:right;">Posted by: <?php echo $news['author']; ?></td>
						</tr>
					</table>
			</div>
			<div class="content">
				<img src="modules/news/categories/<?php echo $news['catimage']; ?>" alt="<?php echo $news['catname']; ?>" align="right" />
				<?php echo BBCode($news['message']); ?>
			</div>
			<div class="contentFooter">
				<table width="100%">
					<tr>
						<td style="text-align:left;">
							View Comments: <a href="?load=news&id=<?php echo $news['news_id']; ?>"><?php echo $numComments;?> Comments</a>
						</td>
						<td style="text-align:right;">Posted on: <?php echo date('D M j, Y g:i a T', strtotime($news['date'])); ?></td>
					</tr>
				</table>
			</div>
	
	<?php	
		CloseTable();
		echo "<br />";
	}
}

/** This was coded on Coda with a MacBook Pro **/
function commentForm(){

	global $db;
	
	if(isset($_POST['processed']))
	{
		$comment = stripslashes($_POST['comment']);
		$author_id = stripslashes($_POST['author']);
		
		echo "Author: {$author_id}<br />Comment: {$comment}<br />";
		echo "Your comment has been processed. Please wait.<br />";
	}
	
	$cur_user_id = 0; //testing variable, until i get the login system working for this
	
	$logged_in = false;
	$result = $db->Query("SELECT `username`, `avatar` FROM `mybb_users` WHERE `uid` = '$cur_user_id' LIMIT 1");
	while(($row = $db->Fetch($result)) != false)
	{
		$username = $row['username'];
		$avatar = $row['avatar'];
		$logged_in = true;
	}

?>
<a name="add"></a>
<h2>Add Your Comment</h2>
	
	<ol class="comment_form_wrap">
		<li> 
			<img src="modules/news/images/comment_arrow.png" class="textarea_arrow" />
			<div class="comment_author">
				<?php
					if($avatar!=""){
						echo "<img src=\"{$avatar}\" height=\"80px\" />";
					}else{
						echo "<img src=\"modules/news/images/avatar.png\" />";
					}
				?>
				<p>
				<?php
					if($logged_in){
						echo $username;
					}else{
						echo "Guest";
					}
				?>
				<br><span><?php echo date('F jS', time()); ?></span></p>
			</div>
			<form action="<?php $_SERVER['PHP_SELF']?>" method="POST" id="comment_form">
				<!-- <fieldset> -->
					<textarea name="comment" id="comment" rows="8" cols="10" tabindex="1" class="input textarea required"></textarea> 
					<input type="hidden" value="<?php echo $cur_user_id; ?>" name="author" />
					<input type="submit" value="Add Comment" name="processed" />
				<!-- </fieldset> -->
			</form>
		</li>
	</ol>
	
<?php
}
?>