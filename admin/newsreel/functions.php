<style> 

ul {
	margin: 0;
}
 
#contentLeft {
	width: 400px;
}
 
#contentLeft li {
	list-style: none;
	margin: 0 0 4px 0;
	padding: 10px;
	background-color:#a1a1a1;
	border: #CCCCCC solid 1px;
	color:#fff;
	text-align:center;
	cursor:move;
}

</style>
<script type="text/javascript" src="scripts/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateReelOrder'; 
			$.post("newsreel/updateDB.php", order, function(theResponse){
				 $("#updateStatus").html(theResponse);
			}); 															 
		}								  
		});
	});
 
});	
</script> 
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
 
 define(MAX_SLIDES, 6);
 
  function EditOrder(){
 	
	 global $db;
	 ?>
	 	 <div id="contentLeft">
	 		<table> 
	 			<tr>
				 	<th>News Reel Order</th>
			 		<td id="updateStatus"></td>
			 	</tr>
		 	</table>
			<ul>
	 <?php
	 $result = $db->Query("SELECT `title`, `slide_id`, `src` FROM `bayonet_newsreel` WHERE `visible` = 1 ORDER BY `weight` ASC");
	 $row = $db->Fetch($result);
	 
	 foreach($row as $slide){
 		echo "<li id=\"recordsArray_{$slide['slide_id']}\">";
		 PrintSlide($slide);
	 	echo "<br /><a href=\"?op=newsreel&disable={$slide['slide_id']}\"><input type=\"button\" value=\"Disable\" /></a></li>";		 
	 }	 
?>	 
		  </ul>
		  Click and drag on a slide to change the order. Wait for confirmation indicating the changes have been saved.
	 	</div> 
<?php
 }
 
 function EnableSlide($slide_id){
 	
	 global $db;
	 $lastspot = GetLastPosition();
	 if($lastspot >= MAX_SLIDES){
	 	ReportError("There are already 6 active slides. You must disable one in order to enable another.");
	 	PageRedirect(3,"?op=newsreel");
		return;	 
	 }
	 $weight = $lastspot+1;
	 $db->Query("UPDATE `bayonet_newsreel` SET `visible` = 1, `weight` = '$weight' WHERE `slide_id` = '$slide_id' LIMIT 1");
	 PageRedirect(0,"?op=newsreel");
 }
 
 function DisableSlide($slide_id){
 	
	 global $db;
	 $result = $db->Query("SELECT `weight` FROM `bayonet_newsreel` WHERE `slide_id` = '$slide_id' LIMIT 1");
	 $slide = $db->FetchRow($result);

	 $oldWeight = $slide['weight'];
	 
	 if($oldWeight < MAX_SLIDES){
		$total = getNumOfActive(); 
		for($i=$oldWeight+1; $i<=$total; $i++){
			//echo "Change Weight:".$i." to ".($i-1)."<br />";
			$new = $i-1;
			$db->Query("UPDATE `bayonet_newsreel` SET `weight` = '$new' WHERE `weight` = '$i' LIMIT 1");	
		} 		  		  		  		 
	 }	 	 	 	 

	 $db->Query("UPDATE `bayonet_newsreel` SET `visible` = 0, `weight` = 0 WHERE `slide_id` = '$slide_id' LIMIT 1");
	 PageRedirect(0,"?op=newsreel");
 }
 
 function ListInactive(){
 	
	 global $db;
	 echo "<h3>Disabled Slides</h3>";
	 $result = $db->Query("SELECT `slide_id`, `title`, `src` FROM `bayonet_newsreel` WHERE `visible` = 0 ORDER BY `slide_id` DESC");
	 $row = $db->Fetch($result);
	 
	 foreach($row as $slide){
	 	echo PrintSlide($slide);
		echo "<br /><a href=\"?op=newsreel&enable={$slide['slide_id']}\"><input type=\"button\" value=\"Enable\" /></a><br /><br />";	
	 }
 }
 
 function PrintSlide($slide){
	echo "{$slide['title']}";
	if(file_exists("../modules/newsreel/slides/{$slide['src']}") && $slide['src'] != ""){
	  echo "<br /><img src=\"../modules/newsreel/slides/{$slide['src']}\" width=\"100px\" />";
 	}
 }
 
 function GetLastPosition(){
 	
	global $db;
	$result = $db->Query("SELECT `weight` FROM `bayonet_newsreel` WHERE `visible` = 1 ORDER BY `weight` DESC LIMIT 1");
	$row = $db->FetchRow($result);
	
 	return $row['weight'];
 }
 
 function getNumOfActive(){
 	global $db;
	$result = $db->Query("SELECT `slide_id` FROM `bayonet_newsreel` WHERE `visible` = 1");
	return $db->Rows($result); 
 }
		

?>