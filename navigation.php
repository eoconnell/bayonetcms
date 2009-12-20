<?php
/**
 * Bayonet Conent Management System
 * Copyright (C) Joseph Hunkeler & Evan O'Connell
 * 
 * Purpose of this software is to allow users to manage their website
 * with ease and without needing to have any coding knowledge in order 
 * to maintain it. Visit www.eodesign.com/cms for any updates or feedback. 
 */
 ?>
<table border="0" cellspacing="0" class="navLinks">
	<tr>
 		<td>&nbsp;&nbsp;<a href="index.php">HOME</a>&nbsp;&nbsp;</td>
<?php
  
   	$result = $db->Query("SELECT * FROM `bayonet_navigation` ORDER BY `weight`");
 	while(($row = $db->Fetch($result))!==false)
	{
		echo '<td>&nbsp;&nbsp;<a href="'.$row['link'].'">'.strtoUpper($row['title']).'</a>&nbsp;&nbsp;</td>';
	}
?>
	</tr>
</table>