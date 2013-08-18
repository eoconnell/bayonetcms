<nav>
	<ul>
		<li><a href="index.php">HOME</a></li>

<?php

	$result = $db->Query("SELECT * FROM `bayonet_navigation` ORDER BY `weight`");
	$nav = $db->Fetch($result);

	foreach ($nav as $link):

		$href = str_replace('&', '&amp;', $link['link']);
		$title = strtoupper($link['title']);
		echo "<li><a href=\"{$href}\">{$title}</a></li>";

	endforeach;
?>

	</ul>
</nav>
