<?php

if(!defined(NO_ACCESS))
{
  ReportError("Access denied.");
}

define("RUDI_DEBUG",true);
define("RUDI_DEBUG_LEVEL",true);
define(NO_REPEAT,'norepeat');
define(REPEAT,'repeat');

static $last_message = NULL;
static $last_message_count = 0;

/*
function decho($message)
{
  echo "<pre>\n";
  if(is_array($message))
  {
    print_r($message);
  }  
  elseif(is_object($message))
  {
    var_dump($message);  
  }
  elseif(is_string($message))
  {
    $message = wordwrap($message,80,'<br />');
    echo "$message\n";
  }  
  echo "</pre>";
}

  function decho($message, $flag = NO_REPEAT)
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
      echo "<pre>";
      if($last_message_count > 0 && !is_array($last_message) && !is_object($last_message))
      {
        echo "Receieved previous message <b>$last_message_count</b> times\n";
      }
      else
      {
        if(is_array($message))
        {
          print_r($message);
        }  
        elseif(is_object($message))
        {
          var_dump($message);  
        }
        elseif(is_string($message))
        {
          $message = wordwrap($message,80,'<br />');
          echo "$message\n";
        }
      }
      echo "</pre>";
      $last_message_count = 0;
    }
    
    $last_message = $message;
    
  }
*/


?>