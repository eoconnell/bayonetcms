<link rel="stylesheet" type="text/css" href="blocks/rss_agw/style.css" media="screen"/>
<?php
/*
function stripBBCode($text_to_search) {
 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
} */

	include 'rssreader.php';
	
    $rss = new rss_php;
    $cacheReadLength = 1024;
    $cacheFile = dirname(__FILE__) . "/rss.cache";
	$url = 'http://www.armedglobalwarfare.com/index.php?type=rss;action=.xml;limit=150';
	
	
	if(!file_exists($cacheFile))
	{
		decho("creating cache<br/>");
		$fp = fopen($cacheRead, "x+");
		fclose($fp);
	}
	
	decho("reading internal cache state<br/>");
	$internal = fopen($cacheFile, "r");
	$cacheRead = fread($internal, $cacheReadLength);
	fclose($internal);
	
	decho("reading inbound cache data<br/>");
	$inbound = fopen($url, "r+");
	$cacheTempRead = fread($inbound, $cacheReadLength);
	fclose($inbound);
	
	decho("comparing<br/>");
	if((strncmp($cacheTempRead, $cacheRead, $cacheReadLength)) == 0)
	{
		$cacheTemp = implode('', file($url));
		decho("Length of cached RSS is " . strlen($cacheTemp) . "<br/>");
		decho("Writing cached data to file <br/>");
		$cachefp = fopen($cacheFile, "w+");
		$cacheWritten = fwrite($cachefp, $cacheTemp, strlen($cacheTemp));
		fclose($cachefp);
		decho("$cacheWritten bytes written to cache.<br/>");			
	}
	else
	{
		decho("cache matches external source, using internal<br/>");			
	}		

	$rss->load($cacheFile);
	
    $items = $rss->getItems(); #returns all rss items
 	
 	$numFeeds = 0;
 	echo "<div class=\"rss\" >";
    foreach($items as $story){
    	if($story['category']=="Tournament Announcements"){
    		$numFeeds++;
    	//	$text = $story['description'];
    	//	$text = stripBBCode($text);
    	//	$text = preg_replace("(\[font(.+?)...)","",$text);
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
