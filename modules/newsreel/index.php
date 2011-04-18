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
<!-- START News Reel -->
<link rel="stylesheet" type="text/css" href="modules/newsreel/style.css" media="screen"/>
<?php OpenContent(); ?>
<div class="content" style="padding: 0px; color: white;">
<script type="text/javascript">

var current = "0";
var stop = false;
var slide=new Array();	//declares a new array called banner
var x=0;				//loop control and array counting variable
var timing=7000;		//value is in milliseconds, used for 3 seconds on each image
<?php
	global $db;
	$x=0;	

	$result = $db->Query("SELECT * FROM `bayonet_newsreel` WHERE `visible`= 1 ORDER BY `weight` ASC LIMIT 0,6");
	//$get_slides = mysql_query("SELECT * FROM `news_slideshow` WHERE `visible`=1");
	$row = $db->fetch($result);
	
	foreach($row as $slide){
		echo 'slide['.$x.']=new Image();';
		echo 'slide['.$x.'].src="modules/newsreel/slides/'.$slide['src'].'";';
		if($x==0){
			$startSRC=$slide['src'];
  		}
		$x++;	
	}
	$width = 100/$x;
?>

	function changeStart()
	{
		document.getElementById(0).style.backgroundImage="url(modules/newsreel/images/slidenavbg2.png)";

	}

	function mouseOverBG(id, image)
	{
		if(id!=current){
			document.getElementById(id).style.backgroundImage="url(modules/newsreel/images/slidenavbg3.png)";
			document.getElementById(id).style.color="#3666ba";
			document.body.style.cursor = 'pointer';
		}
	}

	function mouseOutBG(id, image)
	{
		if(id!=current){
			document.getElementById(id).style.backgroundImage="url(modules/newsreel/images/slidenavbg.png)";
			document.getElementById(id).style.color="white";
			document.body.style.cursor = 'default';
		}
	}
	function nextSlide(num, clicked)
	{
		if(num!=current){
			document.myBanner.src=slide[num].src;
			document.getElementById(num).style.backgroundImage="url(modules/newsreel/images/slidenavbg2.png)";
			document.getElementById(current).style.backgroundImage="url(modules/newsreel/images/slidenavbg.png)";
			document.getElementById(num).style.color="white";
			document.body.style.cursor = 'default';
			current=num;
			if(clicked){
				stop=true;
			}
		}
	
	}
	function playBanner()
	{
		if(!stop){
			if(document.images)
			{
               		 if(document.myBanner.complete)
				{
					nextSlide(x,false)
					x++;
				}
               	if(x==<?php echo $x; ?>){
					x=0;
				}
				var timerId=setTimeout("playBanner()", timing);
			}
		}
	}
	function init_Slides(){
		changeStart();
		playBanner();	
	}
	
window.onload = init_Slides;	//starts the reels movement


</script>


	<a href="http://www.3rd-infantry-division.org/forums/index.php?board=13.0"><img src="modules/newsreel/slides/<?php echo $startSRC; ?>" name="myBanner" alt="newsreel" style="padding:0px;" /></a>

</div>
	<table border="0" cellspacing="0" cellpadding="0" style="height:21px;" width="100%">
	<tr>
<?php
$y=0; 
		$result = $db->Query("SELECT * FROM `bayonet_newsreel` WHERE `visible`= 1 ORDER BY `weight` ASC LIMIT 0, 6");
		$row = $db->Fetch($result);
		
		foreach($row as $link){
			echo "<td id=\"{$y}\" width=\"{$width}%\" class=\"slidenav\" onclick=\"javascript:nextSlide(this.id, true); return false;\" onmouseover=\"javascript:mouseOverBG(this.id); return false;\" onmouseout=\"javascript:mouseOutBG(this.id); return false;\">{$link['title']}</td>\n";	
			$y++;
		} 
?>
	</tr>
	</table>

<?php CloseContent(); ?>
<!-- END News Reel -->
