<link rel="stylesheet" type="text/css" href="blocks/rss_agw/style.css" media="screen"/>
<?php

function stripBBCode($text_to_search) {
 $pattern = '|[[\/\!]*?[^\[\]]*?]|si';
 $replace = '';
 return preg_replace($pattern, $replace, $text_to_search);
}

	include 'rssreader.php';
		
    $rss = new rss_php;

    $rss->load('http://www.armedglobalwarfare.com/index.php?type=rss;action=.xml;limit=150');

    $items = $rss->getItems(); #returns all rss items
 	
 	$numFeeds = 0;
 	echo "<div class=\"rss\" >";
    foreach($items as $story){
    	if($story['category']=="Tournament Announcements"){
    		$numFeeds++;
    	//	$text = $story['description'];
    	//	$text = preg_replace("(\[font(.+?)...)","",$text);
    		echo "<a href=\"{$story['link']}\" target=\"_blank\"><span class=\"title\">{$story['title']}</span></a><br />
    				<span class=\"date\">{$story['pubDate']}</span><br />";
			echo "{$text}<br /><br />";    	
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
