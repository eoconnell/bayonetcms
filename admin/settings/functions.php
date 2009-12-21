<?php
/**
 * Bayonet Content Management System
 * Copyright (C) 2008  Joseph Hunkeler & Evan O'Connell
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
 * Note to anyone feeling the need to edit this file...
 * You MUST declare $db as global inside your functions in order access MySQL from here.
 */


function changePassword(){
echo "<script type=\"text/javascript\" src=\"scripts/mocha.js\"></script>";	
	global $db;
	
	if(isset($_POST['processed']))
	{
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		
		if($password != $confirm){
			ReportError("The passwords you entered did not match.");
			PageRedirect(3, "?op=settings&change=password");
			return;		
		}else if(strlen($password)<6){
			ReportError("The password you entered is less than 6 characters.");
			PageRedirect(3, "?op=settings&change=password");
			return;		
		}
		$newpassword = crypt(md5($password),'iamnotadirtywhorebitch');
		$username = $_SESSION['username'];
		$db->Query("UPDATE `bayonet_users` SET `password` = '$newpassword' WHERE `username` = '$username' LIMIT 1");
		
		echo "Your password has successfully been changed.";
		PageRedirect(3,"?op=settings");
		return;	
	}
?>
<div id="pwordCont">
<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
<h1>Change Your Password</h1>
	<table>
	<tr>
		<td class="right">Password: </td>
		<td><input type="password" id="inputPassword" name="password" style="width:200px;" /></td>
		<td>
			<table cellspacing="0">
			<tr><td>Password Strength:</td><td id="complexity"></td></tr>
			<tr><td colspan="2"><div class="outer"><div id="rating"></div></div></td></tr>
			</table>
		</td>
	</tr>
	<tr><td></td><td style="text-align:center; color:#626262;">Minimum of 6 Characters</td><td></td></tr>
	<tr>
		<td>Confirm Password: </td>
		<td><input type="password" name="confirm" style="width:200px;" /></td>
	</tr>
	<tr><td colspan="2"><input type="submit" value="Change Password" name="processed" /></td>
	</table>
</form>
</div>
<?php
}