<?php 
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler
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
 
/**
 * bbcode_format()
 * 
 * Modified public domain code from www.phpit.net
 * 
 * @param mixed $str
 * @return
 */
 
include_once 'classes.php';

function bbcode_format ($str) 
{
  $str = htmlentities($str);
  $str = strip_tags($str);
  //$str = wordwrap($str,100,"\n",true);
  
  $simple_search = array(
    '/\[b\](.*?)\[\/b\]/is',                               
    '/\[i\](.*?)\[\/i\]/is',                               
    '/\[u\](.*?)\[\/u\]/is',
    '/\[s\](.+?)\[\/s\]/is',
    '/\[hr\]/is',
    '/\[pi\](.*?)\[\/pi\]/is',
    '/\[title\](.*?)\[\/title\]/is',
    '/\[article\](.*?)\[\/article\]/is',
    '/\[section\](.*?)\[\/section\]/is',
    '/\[code\](.*?)\[\/code\]/is',
    '/\[quote\](.*?)\[\/quote\]/is',
    '/\[quote\=(.*?)\](.*?)\[\/quote\]/is',
    '/\[url\](.*?)\[\/url\]/is',
    '/\[url\=(.*?)\](.*?)\[\/url\]/is',
    '/\[align\=(.*?)\](.*?)\[\/align\]/is',
    '/\[size\=(.*?)\](.*?)\[\/size\]/is',
    '/\[img\=(.*?)\](.*?)\[\/img\]/is',
    '/\[img align\=(.+?)\](.+?)\[\/img\]/is',
    '/\[mail\](.*?)\[\/mail\]/is',
    '/\[mail\=(.*?)\](.*?)\[\/mail\]/is'
    );

  $simple_replace = array(
    '<strong>$1</strong>',
    '<em>$1</em>',
    '<u>$1</u>',
    '<span class="strikethrough">$1</span>',
    '<hr>',
    '<p style="text-indent:3em;">$1</p>',
    '<h2>$1</h2>',
    '<h3>$1</h3>',
    '<h4>$1</h4>',
    '<blockquote><pre>$1</pre></blockquote>',
    '<blockquote>$1</blockquote>',
    '<i>$1 wrote:</i><br/><blockquote>$2</blockquote>',
    '<a href="$1">$1</a>',
    '<a href="$1">$2</a>',
    '<div style="text-align: $1">$2</align>',
    '<font style="font-size:$1px;">$2</font>',
    '<img src="$1" alt="$2"/>',
    '<img src=\"$2\" align=\"$1\" />',
    '<a href="mailto:$1">$1</a>',
    '<a href="mailto:$1">$2</a>'
    );
    
  
  $str = preg_replace ($simple_search, $simple_replace, $str);
  $str = nl2br($str);
  return $str;
}

/**
 * BBcode 2 HTML was written by WAY2WEB.net
 */
function BBCode($Text)
       {
         // Replace any html brackets with HTML Entities to prevent executing HTML or script
            // Don't use strip_tags here because it breaks [url] search by replacing & with amp
            $Text = str_replace("<", "&lt;", $Text);
            $Text = str_replace(">", "&gt;", $Text);

            // Convert new line chars to html <br /> tags
            $Text = nl2br($Text);

            // Set up the parameters for a URL search string
            $URLSearchString = " a-zA-Z0-9\:\/\-\?\&\.\=\_\~\#\'";
            // Set up the parameters for a MAIL search string
            $MAILSearchString = $URLSearchString . " a-zA-Z0-9\.@";

            // Perform URL Search
            $Text = preg_replace("/\[url\]([$URLSearchString]*)\[\/url\]/", '<a href="$1" target="_blank">$1</a>', $Text);
            $Text = preg_replace("(\[url\=([$URLSearchString]*)\](.+?)\[/url\])", '<a href="$1" target="_blank">$2</a>', $Text);
         //$Text = preg_replace("(\[url\=([$URLSearchString]*)\]([$URLSearchString]*)\[/url\])", '<a href="$1" target="_blank">$2</a>', $Text);

            // Perform MAIL Search
            $Text = preg_replace("(\[mail\]([$MAILSearchString]*)\[/mail\])", '<a href="mailto:$1">$1</a>', $Text);
            $Text = preg_replace("/\[mail\=([$MAILSearchString]*)\](.+?)\[\/mail\]/", '<a href="mailto:$1">$2</a>', $Text);
         
            // Check for bold text
            $Text = preg_replace("(\[b\](.+?)\[\/b])is",'<span class="bold">$1</span>',$Text);

            // Check for Italics text
            $Text = preg_replace("(\[i\](.+?)\[\/i\])is",'<span class="italics">$1</span>',$Text);

            // Check for Underline text
            $Text = preg_replace("(\[u\](.+?)\[\/u\])is",'<span class="underline">$1</span>',$Text);

            // Check for strike-through text
            $Text = preg_replace("(\[s\](.+?)\[\/s\])is",'<span class="strikethrough">$1</span>',$Text);

            // Check for over-line text
            $Text = preg_replace("(\[o\](.+?)\[\/o\])is",'<span class="overline">$1</span>',$Text);

            // Check for colored text
            $Text = preg_replace("(\[color=(.+?)\](.+?)\[\/color\])is","<span style=\"color: $1\">$2</span>",$Text);

            // Check for sized text
            $Text = preg_replace("(\[size=(.+?)\](.+?)\[\/size\])is","<span style=\"font-size: $1px\">$2</span>",$Text);

            // Check for list text
            $Text = preg_replace("/\[list\](.+?)\[\/list\]/is", '<ul class="listbullet">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=1\](.+?)\[\/list\]/is", '<ul class="listdecimal">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=i\](.+?)\[\/list\]/s", '<ul class="listlowerroman">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=I\](.+?)\[\/list\]/s", '<ul class="listupperroman">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=a\](.+?)\[\/list\]/s", '<ul class="listloweralpha">$1</ul>' ,$Text);
            $Text = preg_replace("/\[list=A\](.+?)\[\/list\]/s", '<ul class="listupperalpha">$1</ul>' ,$Text);
            $Text = str_replace("[*]", "<li>", $Text);

            // Check for font change text
            $Text = preg_replace("(\[font=(.+?)\](.+?)\[\/font\])","<span style=\"font-family: $1;\">$2</span>",$Text);

            // Declare the format for [code] layout
            $CodeLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="quotecodeheader"> Code:</td>
                                </tr>
                                <tr>
                                    <td class="codebody">$1</td>
                                </tr>
                           </table>';
            // Check for [code] text
            $Text = preg_replace("/\[code\](.+?)\[\/code\]/is","$CodeLayout", $Text);
            // Declare the format for [php] layout
            $phpLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="quotecodeheader"> Code:</td>
                                </tr>
                                <tr>
                                    <td class="codebody">$1</td>
                                </tr>
                           </table>';
            // Check for [php] text
            $Text = preg_replace("/\[php\](.+?)\[\/php\]/is",$phpLayout, $Text);

            // Declare the format for [quote] layout
            $QuoteLayout = '<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="quotecodeheader"> Quote:</td>
                                </tr>
                                <tr>
                                    <td class="quotebody">$1</td>
                                </tr>
                           </table>';
                     
            // Check for [quote] text
            $Text = preg_replace("/\[quote\](.+?)\[\/quote\]/is","$QuoteLayout", $Text);
         
            // Images
            // [img]pathtoimage[/img]
            $Text = preg_replace("/\[img\](.+?)\[\/img\]/", '<img src="$1" />', $Text);
            
            //[img=align]image source[/img]
            $Text = preg_replace("(\[img align\=(.+?)\](.+?)\[\/img\])is","<img src=\"$2\" align=\"$1\" />",$Text);
         
            // [img=widthxheight]image source[/img]
            $Text = preg_replace("/\[img\=([0-9]*)x([0-9]*)\](.+?)\[\/img\]/", '<img src="$3" height="$2" width="$1" />', $Text);
            
            // Alignment
            // [align=type]text[/align]
            $Text = preg_replace("(\[align=(.+?)\](.+?)\[\/align\])is","<div style=\"text-align: $1\">$2</div>",$Text);
         
           return $Text;
      }
      
function articleHeading($text){
	
	// Set the content-type
	header('Content-type: image/png');

	//$text = $_GET['text'];

	$im = imagecreatefrompng('images/news_header.png'); // open image
	imagealphablending($im, true); // setting alpha blending on
	imagesavealpha($im, true); // save alphablending setting (important)

		// Create some colors
		$black = imagecolorallocate($im, 0, 0, 0);


		// Replace path by your own font path
		//$font = 'TrajanPro-Regular.otf';
		//$font = 'TrajanPro-Bold.otf';
		$font = 'BrushScriptStd.otf';
		//$font = 'TRATS__.TTF';
		//$text = strtoupper($text);

		// Add the text
		imagettftext($im, 18, 0, 0, 17, $black, $font, $text);

		// Using imagepng() results in clearer text compared with imagejpeg()
		imagepng($im);
		imagedestroy($im);
}

function LinkList($array)
{
  if(!is_array($array))
  {
    ReportError("List was not an array");
    return;
  }
  
  echo "<ul class=\"block\">";
  foreach($array as $text => $link)
  {
    echo "<li><a href=\"$link\">$text</a></li>";
  }
  echo "</ul>";
}

/**
 * LinkModule()
 * 
 * Helper function to link to Bayonet modules.
 * 
 * @param mixed $module_name
 * @param mixed $link_name
 * @return
 */
function LinkModule($module_name,$args = NULL,$link_name)
{
	
	return "<a href=\"index.php?load={$module_name}{$args}\">{$link_name}</a>";
}

/**
 * LinkModuleFile()
 * 
 * Helper function to link to Bayonet internal module files.
 * 
 * @param mixed $module_name
 * @param mixed $link_name
 * @return
 */
 function LinkModuleFile($module_name, $file_name, $link_name)
 {
 	return "<a href=\"?load={$module_name}&amp;file={$file_name}\">{$link_name}</a>";
 }
 
/**
 * LinkPage()
 * 
 * Helper function to link to Bayonet pages.
 * 
 * @param mixed $page_id
 * @param mixed $page_name
 * @return
 */
function LinkPage($page_id,$page_name)
{
  return "<a href=\"?load=page&amp;id={$page_id}\">{$page_name}</a>";
}

/**
 * LinkInternal()
 *
 * Helper function to link to a relative Bayonet path.
 *  
 * @param mixed $name
 * @param string $rel_path
 * @param string $file
 * @return
 */
function LinkInternal($name,$file,$rel_path = "./")
{   
  return "<a href=\"{$rel_path}{$file}\">{$name}</a>";
}

if(!defined("CALLED_FROM_ADMIN"))
{
  /**
   * OpenTable()
   * Begins a Bayonet site table.
   * @return
   */
  function OpenTable($width = "100%")
  {
    //width="100%" is important.  Otherwise all of our tables will be text width.
    echo "<table width=\"{$width}\" align=\"center\" class=\"cleartable\">\n";
  }
  
  /**
   * CloseTable()
   * Closes a Bayonet site table.
   * @return
   */
  function CloseTable()
  {
    echo "</table>";
  }
  
  /**
   * OpenContent()
   * Begins a Bayonet site table.
   * @return
   */
  function OpenContent()
  {
  	echo "<div class=\"contentBorder1\">";
	echo "<div class=\"contentBorder2\">";
  }
  
  /**
   * CloseContent()
   * Closes a Bayonet site table.
   * @return
   */
  function CloseContent()
  {
    echo "</div>";
   	echo "</div>";
  }
}

function OpenBlock($title = 'New Block')
{
  OpenContent();
  echo "<div class=\"contentHeading\">{$title}</div>";
  echo "<div class=\"content\">";
}

function CloseBlock()
{
  echo "</div>";
  CloseContent();
}

static $error_stack_messages = array(); //global stack of errors accumulated throughout execution
function push_error_stack($message)
{
	global $error_stack_messages;
	
	if(count($error_stack_messages) >= 100)
		array_pop($error_stack_messages);
		
	array_push($error_stack_messages, $message);
}

function fatal_error_handler($buffer) {
  if (ereg("(error</b>:)(.+)(<br)", $buffer, $regs) ) {
    $err = preg_replace("/<.*?>/","",$regs[2]);
    //ReportError($err);
  }
  return $buffer;
}

function handle_error ($errno, $errstr, $errfile, $errline)
{
    //decho("<b>Warning:</b> $errfile:$errline, $errstr");
    push_error_stack("<b>Error Number:</b> $errno<br/><b>Error:</b> $errstr<br/><b>In File:</b> $errfile<br/><b>Line:</b> $errline");
    if($errno == FATAL || $errno == ERROR){
    	push_error_stack($errstr);
        ob_end_flush();
        exit(0);
    }
}

/**
 * ReportError()
 * 
 * This function should be called in the event that an error has occured.
 * 
 * @param mixed $message - automatically logged
 * @return
 */
function ReportError($message)
{
  //WriteLog($message,BAYONET_LOG_ERROR);
  OpenContent();
  echo "<div class=\"contentHeading\">Error Message</div><div class=\"content\">{$message}</div>";
  CloseContent();
}

/**
 * ReportHack()
 * 
 * This function should be called in the event that we are confirming
 * a hacking attempt.
 * 
 * @param mixed $message - automatically logged
 * @return void
 */
function ReportHack($message)
{
  //WriteLog($message,BAYONET_LOG_HACK);
  OpenContent();
  echo "<div class=\"contentHeading\">Hacking Attempt</div><div class=\"content\">{$message}</div>";
  CloseContent();
}

/**
 * PageRedirect()
 * 
 * performs an http redirect
 * 
 * @param $delay
 * @param $link
 */
function PageRedirect($delay, $link)
{
	echo "<meta http-equiv=\"Refresh\" content=\"{$delay};url={$link}\">";
}


/**
 * array_dump()
 * 
 * Useful against $_POST and $_GET variables, for dumping data to
 * a log file, or to stdout.  The return value is a single string,
 * with each array key => value pair delimited by a character.
 * The default character is a pipe -> '|'.  It is assumed that if
 * wanted to have a newline character inserted, just replace $spacer
 * with '\n'.
 * 
 * @param mixed $array
 * @param string $spacer
 * @return
 */
function array_dump($array, $spacer = '|')
{
  $retval = NULL;
  foreach($array as $challenge => $answer)
  {
    $retval .= " $challenge => $answer " . $spacer;
  }  
  
  return $retval;
}

/**
 * WriteLog()
 * 
 * This function can be accessed directly, however, anything that is 
 * passed to ReportError() or ReportHack(), or decho() will be logged in their
 * appropriate log file.
 * 
 * Change made: added checks to see if the log files exist before opening
 * 
 * @param mixed $message
 * @param mixed $flag
 * @return
 */
define('BAYONET_LOG_HACK','bayonet_log_hack');
define('BAYONET_LOG_ERROR','bayonet_log_error');
define('BAYONET_LOG_WARN','bayonet_log_warn');
define('BAYONET_LOG_INFO','bayonet_log_info');

function WriteLogBayonet($message,$flag)
{ 
  global $config;
  $enabled = $config['logs']['enabled'];
  
  if(!$enabled)
  {
    return false;
  }
  
  $dir = $config['logs']['dir'];
  date_default_timezone_set($config['logs']['timezone']);
  $varstr = array_dump($_GET);
  $type = NULL;
  $ip = $_SERVER['REMOTE_ADDR'];
  $hostname = gethostbyaddr($ip);
  $executed = $_SERVER['PHP_SELF'];
  $timestamp = date('Y-M-d H:i:s T');


  $message = str_replace("\n",'',$message);
  $message = str_replace("<br>",'',$message);
  
  switch($flag)
  {
    case BAYONET_LOG_HACK:
    if(!file_exists($dir.'hacks.log')){
   	  	break;   	  
   	  }
      $fp = fopen($dir.'hacks.log','a');
      $type = 'HACK';      
      $full_message = "TIMESTAMP: {$timestamp}\n\t\tIP: {$ip}\n\t\tHOSTNAME: {$hostname}\n\t\tACTION: {$type} of {$executed}\n\t\tDEFERRAL: {$message}\n\t\tVAR: ({$varstr})\n\n";
      break;
    case BAYONET_LOG_ERROR:
 	  if(!file_exists($dir.'error.log')){
   	  	break;   	  
   	  }
      $fp = fopen($dir.'error.log','a');
      $type = 'ERROR';
      $full_message = "({$timestamp}) - {$type} - {$message} - ({$varstr})\n";
      break;
    case BAYONET_LOG_WARN:
 	  if(!file_exists($dir.'warn.log')){
   	  	break;   	  
   	  }
      $fp = fopen($dir.'warn.log','a');
      $type = 'WARN';
      $full_message = "({$timestamp}) - {$type} - {$message} - ({$varstr})\n";
      break;      
    case BAYONET_LOG_INFO:
   	  if(!file_exists($dir.'info.log')){
   	  	break;   	  
   	  }
      $fp = fopen($dir.'info.log','a');
      $type = 'INFO';
      $full_message = "({$timestamp}) - {$type} - {$message}\n";
      break;
    default:
      echo 'To log something, you need to define a log to write to.<br>';
      return;
  }
  if(file_exists($fp)){
  	fwrite($fp,$full_message);
  	fclose($fp);
  }else{
  	//echo "could not write to file because file does not exist.<br />";  
  }
}

/**
 * UnderConstruction()
 *
 * Displays a site-wide message across the page header.
 *  
 * @param mixed $message
 * @param mixed $flag Acceptable flags are BAYONET_SITE, and BAYONET_SECTION
 * @return
 */
define('BAYONET_SITE','bayonet_site');
define('BAYONET_SECTION','bayonet_section');
function UnderConstruction($message = NULL, $flag = BAYONET_SITE)
{
  $timestamp = date("Y-M-d h:m:s");
  OpenTable();
    switch($flag)
    {
      case BAYONET_SITE:
        echo "<tr><th>Site is currently under construction : $timestamp</th></tr>";
        break;
      case BAYONET_SECTION:
        echo "<tr><th>Section currently under construction : $timestamp</th></tr>";
    }

  if(!is_null($message))
  {
    echo "<tr><td><i>$message</i></td></tr>";
  }
    
  CloseTable();
  echo "<br>";
}

/**
 * valid_result()
 * 
 * Determine if a mysqli result is valid.  
 * Can be used on normal objects to check if they are empty.
 * 
 * @param mixed $p_result
 * @return 
 */
function valid_result($p_result)
{
	if(is_object($p_result) && count($p_result) <= 1)
  		return false;
	else
		return true;
}

/**
 * GetBlocks()
 * 
 * Includes all directories listed in blocks/ and uses the bayonet_blocks
 * MySQL table to determine the order of the blocks displayed.
 * 
 * @return
 */

define('BLOCK_LEFT', 0);
define('BLOCK_RIGHT', 1);

function GetBlocks($position = BLOCK_LEFT)
{
  global $config;  
  global $db;
  	
  $query = sprintf("SELECT block_id, active, weight, position, dir_name, title FROM bayonet_blocks WHERE active = 1 AND position = %d ORDER BY weight", (int)$position);
  $result = $db->Query($query);
  
  /* Is the result valid? */
  if($db->Rows($result) < 1) 
  	return false;

  $blocks = $db->Fetch($result);
  if(empty($blocks)) return;
  
  foreach($blocks as $block)
  {
      $load = 'blocks/'.$block['dir_name'].'/index.php';
      if(file_exists($load))
      {
      	OpenBlock($block['title']);
        include_once $load;
        CloseBlock();
        decho("'{$block['dir_name']}' block loaded");
      }
      else
      {
        ReportError("Failed to load block, '{$block['dir_name']}'.  Check block config.");
      }
      if($config['blocks']['spacer']) echo "<br />";
  }
}
?>