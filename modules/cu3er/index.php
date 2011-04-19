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
?>
<?php  OpenContent();  ?>
<!--  STEP ONE: insert path to SWFObject JavaScript -->
<script type="text/javascript" src="modules/cu3er/js/swfobject/swfobject.js"></script>

<!--  STEP TWO: configure SWFObject JavaScript and embed CU3ER slider -->
<script type="text/javascript">
		var flashvars = {};
		flashvars.xml = "modules/cu3er/config2.xml";
		flashvars.font = "font.swf";
		var attributes = {};
		attributes.wmode = "transparent";
		attributes.id = "slider";
		swfobject.embedSWF("modules/cu3er/cu3er.swf", "cu3er-container", "640", "320", "9", "modules/cu3er/js/swfobject/expressInstall.swf", flashvars, attributes);
</script>
<style type="text/css">
<!--
#cu3er-container {width:640px; outline:0;}
-->
</style>

<!--  STEP THREE: insert CU3ER div container -->
<div id="cu3er-container" style="background-color:black;">
    <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
    </a>
</div>
<?php CloseContent(); ?>

<?php //include'cuber.html'; ?> 

/* <description> 
				<link target="_blank">http://www.3rd-infantry-division.org/forums/index.php?board=13.0</link>	
				<heading>Enlist Today!</heading> 
				<paragraph>Some text.</paragraph> 
			</description>	 */		
