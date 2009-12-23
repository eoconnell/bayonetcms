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

global $config;
 
define("RUDI_DEBUG",true);
define("RUDI_DEBUG_LEVEL",true);
define('NO_REPEAT',false);
define('REPEAT',true);

static $last_message = NULL;
static $last_message_count = 0;

static $log_message_last = NULL;
static $log_message_queue = array();
static $log_message_pos = 0;

function decho2($message)
{
	global $log_message_last, $log_message_queue, $log_message_pos, $config;
	date_default_timezone_set($config['logs']['timezone']);
	$timestamp = date('Y-M-d H:i:s T');
	$message = "[$timestamp]: $message";
	array_push($log_message_queue, $message);
	$log_message_pos++;
}

function logQueueFlush()
{
	global $log_message_queue, $config;
	$messageCount = 0;
	static $log_message_last_count = 0;
	static $next = false;
	
	echo "<div class=\"contentHeading\">Bayonet Debug Messages</div>";
	echo "<div class=\"content\">";
	foreach($log_message_queue as $message)
	{
		if($message != $log_message_queue[$messageCount - 1])
		{
			echo "{$messageCount}: $message<br/>\n";
		}
		elseif($message == $log_message_queue[$messageCount - 1])
		{
			$log_message_last_count++;
			if($config['debug']['repeat_messages'] == false)
			{
				echo "{$messageCount}: $message<br/>\n";
		 		if($config['debug']['repeat_messages'] == true)
 				{
 					if($log_message_queue[$messageCount + 1] != $message)
					{
						$next = true;
					}
				}
			}
		}
		
		if($next == true)
		{
			echo "$messageCount: <b>Last message recieved $log_message_last_count times</b><br/>\n";
			$log_message_last_count = 0;
			$next = false;
		}
		
		$messageCount++;
	}
	echo "</div>";
}

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



?> 