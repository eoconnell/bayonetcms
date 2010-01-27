<link rel="stylesheet" type="text/css" href="blocks/rss_agw/style.css" media="screen"/>
<?php 
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// {{{ prerequesists

/**
 * Check to make sure the cURL extension is available to us
 */
if (!extension_loaded('curl')) {
    $prefix = (PHP_SHLIB_SUFFIX === 'dll') ? 'php_' : '';
    if (!@dl($prefix . 'curl.' . PHP_SHLIB_SUFFIX)) {
        trigger_error('Unable to load the PHP cURL extension.', E_USER_ERROR);
        exit;
    }
}

// {{{ constants

/**
 * Armed Global Warfare Feed
 */
define('AGW_FEED', 'http://www.armedglobalwarfare.com/index.php?type=rss;action=.xml;limit=300');

/**
 * Cache File
 */
define('AGW_CACHE', dirname(__FILE__) . '/rss_cache.xml');
define('AGW_AGE_CACHE', time() - 3600);

/**
 * Feed Variables
 */
$agwFeed      = array();
$agwXml       = null;
$agwProcess   = true;

// }}}

// {{{ main

/**
 * Check existance of cache
 */
if (file_exists(AGW_CACHE) && (filectime(AGW_CACHE) > AGW_AGE_CACHE)) {
	$agwFeed    = simplexml_load_file(AGW_CACHE);
	$agwProcess = false;
}

/**
 * If we don't have a cache then we'll need to build one
 */
if ($agwProcess === true) {
    /**
     * Set up global options for cURL to utilize for the transfer.
     */
    $options = array(CURLOPT_FORBID_REUSE   => true,
                     CURLOPT_POST           => false,
                     CURLOPT_RETURNTRANSFER => true,
                     CURLOPT_TIMEOUT        => 3,
                     CURLOPT_USERAGENT      => 'Mozilla/5.0 (Compatible; libCURL)',
                     CURLOPT_VERBOSE        => false);
    
    /**
     * Initialize cURL
     */
    $agwFeedSource = curl_init(AGW_FEED);
    curl_setopt_array($agwFeedSource, $options);
    
    /**
     * Execute cURL container and store the output
     */
    $agwFeedOutput = curl_exec($agwFeedSource);
    
    /**
     * Parse the received data
     */

    if (!curl_errno($agwFeedSource)) {
    	$agwFeed = simplexml_load_string($agwFeedOutput);
    	$agwXml  = new SimpleXMLElement($agwFeedOutput);
    	
    	file_put_contents(AGW_CACHE, $agwXml->asXML(), LOCK_EX);
    	curl_close($agwFeedSource);
    }
    else {
    	curl_close($agwFeedSource);
    }

    /**
     * Check to make sure the results are not empty before proceeding.
     */
    if (empty($agwFeed) || !is_object($agwFeed)) $agwFeed = array();
}

/**
 * Process output
 */
foreach ($agwFeed->channel->item as $item) {
	if ($item->category != 'Tournament Announcements') continue;
	
	echo '<a href="' . $item->link . '" onclick="javascript:window.open(this.href, \'_blank\'); return false;">' .
	     '<span class="title">' . $item->title . '</span></a><br />' .
	     '<span class="date">' . $item->pubDate . '</span><br /><br /><hr />' . PHP_EOL;
}
// }}}
?>
