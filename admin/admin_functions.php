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
 
if(!defined("ADMIN_FILE"))
{
  die("Access denied.");
  return;
}

function is_loggedin()
{
  $id = session_id();
  if($id == "")
  {
    header("location: index.php");
    return false;
  }
  return true;
}

function login()
{
  global $db;
  
  if(isset($_SESSION['username']) || isset($_SESSION['password']))
  {
    return true;
  }
  
  if(isset($_POST['processed']))
  {
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);
    $password = crypt(md5($password),'iamnotadirtywhorebitch');
    $result = $db->Query("SELECT * FROM bayonet_users WHERE username = '$username' AND password = '$password' LIMIT 1");
    $rows = $db->Rows($result);
    $row = $db->Fetch($result);
    
    if($rows > 0)
    {
      $_SESSION['username'] = stripslashes($username);
      $_SESSION['password'] = stripslashes($password);
      $_SESSION['level'] = $row['level'];
      return true;
    }
    else
    {
      ReportError("Login incorrect.");
      
	  //NOT CORRECT LOGIN, DEFAULT TO LOGIN PAGE
      echo "<meta http-equiv=\"Refresh\" content=\"1;url=index.php\">";
      
      return false;
    }
    
  }
  else
  {
    echo "<form action=\"\" method=\"post\">\n";
    //OpenTable();
    echo "<table style=\"width:100%; height:600px;\">";
      echo "<tr><td><table width=\"450px\" style=\"background-color:white;\" align=\"center\">\n
      <tr><td colspan=\"2\" style=\"text-align:center;\"><img src=\"images/bayonet_logo.jpg\" /></td></tr>\n
      <tr><th colspan=\"2\">Administrative Login</th></tr>\n
      <tr><th style=\"text-align:right;\">Username</th><td><input size=\"20\" type=\"text\" name=\"username\"></td></tr>\n
      <tr><th style=\"text-align:right;\">Password</th><td><input size=\"20\" type=\"password\" name=\"password\"></td></tr>\n
      <tr><th colspan=\"2\" align=\"center\"><input type=\"Submit\" name=\"processed\" value=\"Login\"></th></tr></td></tr>\n
      </table>\n";
    //CloseTable();
    echo "</table>";
    echo "</form>\n";
    return false;
  }
}

function logout()
{
  session_unset();
  session_destroy();
  
  echo "<script>location.href=\"index.php\";</script>";
}

/**
 * CompileAdmin()
 *
 *  because we want to have a horizontal display of options, we need to have
 *  the data separated by arrays.  the data is processed into single tables, and is
 *  echoed in realtime.  we checked to make sure they were arrays, but there is no
 *  checking to make sure the data passed is not malicious in nature.
 *  
 * @param mixed $head
 * @param mixed $body
 * @return
 */
function CompileAdmin($head,$body)
{
  /*if we were not passed arrays, then say goodbye*/
  if(!is_array($head) || !is_array($body))
  {
    echo "must be array\n";
    return;
  }  
  
  echo "<table class=\"cleartable\" width=\"100%\">";

$num = 1;
  foreach($body as $td)
  {
  	if($num==1){
  		echo "<tr style=\"text-align:center; height:90px;\">";	
  	}
    echo "<td class=\"center\" style=\"width:16%;\">$td</td>\n";
    if($num%6 == 0){
    	echo "</tr>";
		$num=0;  
    }
    $num++;
  }
  echo "</tr></table>\n";
}

/**
 * OpenTable()
 *
 *  The administration OpenTable() function requires an argument to define
 *  the header title. It may be wise to replace the standard OpenTable() function
 *  with this one...  that's alot of code to unfuck though. 
 * 
 * @param mixed $title
 * @return
 */
function OpenTable_Ex($title)
{
  echo "<table align=\"center\"><tr><th>{$title}</th></tr><tr><td>";
}

/**
 * CloseTable()
 * 
 * @return
 */
function CloseTable_Ex()
{
  echo "</td></tr></table>";
}

?> 