<!-- START News Reel -->
<?php OpenContent(); ?>
<script type="text/javascript">

var current = "0";
var stop = false;
var slide=new Array();	//declares a new array called banner
var x=0;				//loop control and array counting variable
var timing=7000;		//value is in milliseconds, used for 3 seconds on each image
<?php
	$x=0;	

	$get_slides = mysql_query("SELECT * FROM `bayonet_newsreel` WHERE `visible`= 1 ORDER BY `weight` ASC LIMIT 0,6");
	//$get_slides = mysql_query("SELECT * FROM `news_slideshow` WHERE `visible`=1");

	while($echo_slides = mysql_fetch_array($get_slides)){
		
		echo 'slide['.$x.']=new Image();';
		echo 'slide['.$x.'].src="modules/newsreel/slides/'.$echo_slides['src'].'";';
                if($x==0){
                    $startSRC=$echo_slides['src'];
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
               		<?php
			echo'  if(x=='.$x.'){
				x=0;}';
             		?>
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

<div class="content1"><div class="content2">
	<img src="modules/newsreel/slides/<?php echo $startSRC; ?>" name="myBanner" alt="newsreel" />
	<table border="0" cellspacing="0" cellpadding="0" height="21px" width="100%">
	<tr>
<?php
$y=0;
	$get_slidenav = mysql_query("SELECT * FROM `bayonet_newsreel` WHERE `visible`= 1 ORDER BY `weight` ASC LIMIT 0, 6");
	while($echo_slidenav = mysql_fetch_array($get_slidenav)){

		echo '<td id="'.$y.'" width="'.$width.'%" class="slidenav" onclick="nextSlide(this.id,true)" onmouseover="mouseOverBG(this.id)" onmouseout="mouseOutBG(this.id)">'.$echo_slidenav['title'].'</td>';
		$y++;
	}
?>
	</tr>
	</table>
</div></div>
<?php CloseContent(); ?>
<!-- END News Reel -->