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
 
define("RUDI_DEBUG",true);
define("RUDI_DEBUG_LEVEL",true);
define('NO_REPEAT',false);
define('REPEAT',true);
define('FORCE', true);

static $last_message = NULL;
static $last_message_count = 0;

static $log_message_last = NULL;
static $log_message_queue = array();
static $log_message_pos = 0;

function decho($message, $force = false)
{
	global $log_message_last, $log_message_queue, $log_message_pos, $config;
	
	if($force == false)
	{
		if($config['debug']['enabled'] == false ||
		$config['debug']['show_messages'] == false) return;
	}
		
	
	date_default_timezone_set($config['logs']['timezone']);
	$timestamp = date('H:i:s T');
	if(!is_array($message) && !is_object($message))
		$message = "[$timestamp]: $message";
	else
	{
		$message = $message;
	}
	
	//if(count($log_message_queue) >= 100) 
	//	array_pop($log_message_queue);
		
	array_push($log_message_queue, $message);
	
	$log_message_pos++;
}

function queuePrint($obj, $force = false)
{
	global $config;
	
	if($force == false)
	{
		if($config['debug']['enabled'] == false ||
		$config['debug']['show_messages'] == false) return;
	}
	
	if(is_array($obj))
	{
		$array_dump = print_r($obj,true);
		if(empty($obj))
		{
			echo "Array was empty<br />\n";
			return;
		}
		echo "<pre>" . $array_dump . "</pre><br/>\n";
		//WriteLog($array_dump,BAYONET_LOG_INFO);
	}  
	elseif(is_object($obj))
	{
		ob_start();
		var_dump($obj);
		$obj_dump = ob_get_contents();
		ob_end_clean(); 
		//htmlentities($obj_dump,ENT_QUOTES);
		//WriteLog($obj_dump,BAYONET_LOG_INFO);
		echo "<pre>" . $obj_dump . "</pre><br/>\n"; 
	}
	elseif(is_string($obj))
	{
		$message = wordwrap($obj,80,'<br />');
		echo $obj . "<br/>\n";
		//WriteLog($message,BAYONET_LOG_INFO);
	}
	else
	{
		echo "queuePrint: Invalid type of " . gettype($obj) . "<br/>\n";
	}
}

function logQueueFlush($force = false)
{
	error_reporting(0);
	global $log_message_queue, $config;
	
	if($force == false)
	{
		if($config['debug']['show_messages'] == false) return;
	} 
	
	$messageCount = 0;
	static $log_message_last_count = 0;
	static $next = false;
	
	//OpenContent();
	echo "<div class=\"contentHeading\">Bayonet Debug Messages</div>";
	echo "<div class=\"content\">";
	
	if(count($log_message_queue) < 1)
	{
		echo "<p>No messages</p>";
		echo "</div></div>";
		return false;
	}
	
	echo "<b>" . count($log_message_queue) . " messages received.</b><br/><br/>\n";
	foreach($log_message_queue as $message)
	{
		if($message != $log_message_queue[$messageCount - 1])
		{	
			if($force)
				queuePrint($message, true);
			else
				queuePrint($message);
		}
		elseif($message == $log_message_queue[$messageCount - 1])
		{
			$log_message_last_count++;
			if($config['debug']['repeat_messages'] == true)
			{
				//echo "{$messageCount}: $message<br/>\n";
				if($force)
					queuePrint($message,true);
				else
					queuePrint($message);
			}
 			if($config['debug']['repeat_messages'] == false)
 			{
 				if($log_message_queue[$messageCount + 1] != $message)
				{
					$next = true;
				}
			}

		}
		
		if($next == true)
		{
			queuePrint("<b>Last message recieved $log_message_last_count times</b><br/>\n");
			$log_message_last_count = 0;
			$next = false;
		}
		
		++$messageCount;
	}
	
	echo "</div>";
	//CloseContent();
	error_reporting(1);
}

/*
function decho($message, $flag = REPEAT)
{
  global $last_message, $last_message_count;
  if($last_message == $message)
  {
    if($flag == NO_REPEAT)
      ++$last_message_count;
    else
      $last_message_count = $last_message_count;
    return;
  }
  elseif($last_message != $message)
  {  
    if($last_message_count > 0 && !is_array($last_message) && !is_object($last_message))
    {
      WriteLog("Receieved previous message <b>$last_message_count</b> times\n",BAYONET_LOG_INFO);
    }
    else
    {
      if(is_array($message))
      {
        $array_dump = print_r($message,true);
        WriteLog($array_dump,BAYONET_LOG_INFO);
      }  
      elseif(is_object($message))
      {
        ob_start();
        var_dump($message);
        $obj_dump = ob_get_contents();
        ob_end_clean(); 
        //htmlentities($obj_dump,ENT_QUOTES);
        WriteLog($obj_dump,BAYONET_LOG_INFO); 
      }
      elseif(is_string($message))
      {
        $message = wordwrap($message,80,'<br />');
        WriteLog($message,BAYONET_LOG_INFO);
      }
    }
    
    $last_message_count = 0;
  }
  
  $last_message = $message;
  
}
*/


?> 
