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
	<ul id="menu"> 
 		<li class="current_page_item"><a href="index.php">HOME</a></li>
<?php
  
   	$result = $db->Query("SELECT * FROM `bayonet_navigation` ORDER BY `weight`");
   	$nav = $db->Fetch($result);

   	foreach ($nav as $link) {
   	  echo '<li class="page_item"><a href="' . str_replace('&', '&amp;', $link['link']) . '">' . strtoupper($link['title']) . '</a></li>'; 
   	}
   	?> 
	</ul><!--end dropmenu--> 