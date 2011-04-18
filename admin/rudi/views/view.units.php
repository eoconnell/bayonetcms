<h3>Unit Structure</h3>
<center>
<?php
	include $basedir.'rudi/includes/functions.units.php';
	if(isset($_GET['unit'])){
			
	}else{
		//list units
		echo '<div style="text-align:left; width:300px;">';	
		DisplayUnits();
		echo '</div>';
		
	}


?>
</center>
<!--
<div style="text-align:left;">
<img src="images/tree_branch.gif" />&nbsp;Kilo Company<br />
<img src="images/tree_blank.gif" /><img src="images/tree_branch.gif" />&nbsp;1st Platoon<br />
<img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_branch.gif" />&nbsp;1st Squad<br />
<img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_leaf.gif" /><img src="images/tree_branch.gif" />&nbsp;Fireteam Alpha<br />
<img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_leaf.gif" /><img src="images/tree_branch.gif" />&nbsp;Fireteam Bravo<br />
<img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_branch.gif" />&nbsp;2nd Squad<br />
<img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_branch.gif" />&nbsp;Fireteam Alpha<br />
<img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_blank.gif" /><img src="images/tree_branch.gif" />&nbsp;Fireteam Bravo<br />
</div>
-->