<link rel="stylesheet" type="text/css" href="blocks/rss_agw/style.css" media="screen"/>
<?php

function stripBBCode($text_to_search) {
 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
}
	include 'rssreader.php';
	
    $rss = new rss_php;
    $cacheReadLength = 1024;
    $cacheFile = dirname(__FILE__) . "/rss.cache";
	$url = 'http://www.armedglobalwarfare.com/index.php?type=rss;action=.xml;limit=150';
	
	if(!file_exists($cacheFile))
	{
		decho("Creating RSS cache");
		$fp = fopen($cacheRead, "x+");
		fclose($fp);
	}
	
	decho("Reading internal RSS cache state");
	$internal = fopen($cacheFile, "r");
	$cacheRead = fread($internal, $cacheReadLength);
	fclose($internal);
	
	decho("Reading inbound RSS cache data");
	$inbound = fopen($url, "r");
	$cacheTempRead = fread($inbound, $cacheReadLength);
	fclose($inbound);
	
	decho("Comparing RSS caches");
	if((strncmp($cacheTempRead, $cacheRead, $cacheReadLength)) == 0)
	{
		$cacheTemp = implode('', file($url));
		decho("Length of cached RSS is " . strlen($cacheTemp));
		decho("Writing cached RSS data to file");
		$cachefp = fopen($cacheFile, "w+");
		$cacheWritten = fwrite($cachefp, $cacheTemp, strlen($cacheTemp));
		fclose($cachefp);
		decho("$cacheWritten bytes written to RSS cache.<br/>");			
	}
	else
	{
		decho("RSS cache matches external source, using internal");			
	}		

	$rss->load($cacheFile);
	
    $items = $rss->getItems(); #returns all rss items
 	
 	$numFeeds = 0;
 	echo "<div class=\"rss\" >";
    foreach($items as $story){
    	if($story['category']=="Tournament Announcements"){
    		$numFeeds++;
    		//$text = $story['description'];
    		//$text = strip_tags($text);
			//$text = preg_replace("(\[font(.+?)...)","", $text);
    		//$text = stripBBCode($text);
    		
    		echo "<a href=\"{$story['link']}\" target=\"_blank\"><span class=\"title\">{$story['title']}</span></a><br />
    				<span class=\"date\">{$story['pubDate']}</span><br />";
			//echo "{$text}<br /><br />";
			echo "<br /><hr />";    	
    	}                
    }
    if(!$numFeeds){
    	echo "No new updates for this news feed.";    
    }
    echo "</div>";
  // echo "<pre>";
  //print_r($items);
   // echo "</pre>";
?> 
