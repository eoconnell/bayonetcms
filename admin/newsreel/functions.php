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
  function ListSlides(){
 	
	 global $db;
	 	 
	 echo "<div id=\"contentLeft\">
	 		<table> 
	 			<tr>
				 	<th>News Reel Order</th>
			 		<td id=\"updateStatus\"></td>
			 	</tr>
		 	</table>
			<ul>";
	 
	 $result = $db->Query("SELECT `title`, `slide_id` FROM `bayonet_newsreel` WHERE `visible` = 1 ORDER BY `weight` ASC");
	 while(($row = $db->fetch($result))!= false){
	 	echo "<li id=\"recordsArray_{$row['slide_id']}\">{$row['title']}</li>";	 
	 }  
?>	 
		  </ul>
	 	</div> 
<?php
 }
 
		

?>