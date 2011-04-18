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

<?//php include'cuber.html'; 

/* <description> 
				<link target="_blank">http://www.3rd-infantry-division.org/forums/index.php?board=13.0</link>	
				<heading>Enlist Today!</heading> 
				<paragraph>Some text.</paragraph> 
			</description>	 */		