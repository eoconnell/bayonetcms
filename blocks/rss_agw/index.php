<link rel="stylesheet" type="text/css" href="blocks/rss_agw/style.css" media="screen"/>
<?php

	include 'rssreader.php';
		
    $rss = new rss_php;

    $rss->load('http://www.armedglobalwarfare.com/index.php?type=rss;action=.xml;limit=30');

    $items = $rss->getItems(); #returns all rss items
 	
 	$numFeeds = 0;
 	echo "<div class=\"rss\" >";
    foreach($items as $story){
    	if($story['category']=="Tournament Announcements"){
    		$numFeeds++;
    		echo "<a href=\"{$story['link']}\" target=\"_blank\"><span class=\"title\">{$story['title']}</span></a><br />
    				<span class=\"date\">{$story['pubDate']}</span><br />
					{$story['description']}<br /><br />";    	
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
