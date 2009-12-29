<script type="text/javascript"> 
	$(document).ready(function(){
	$(".flip").click(function(){
	$(".slidepanel").slideToggle("slow");
	});
	});
</script>
 
<style type="text/css"> 
	p.flip
	{
		margin:0px;
		padding:5px;
		text-align:center;
		background: #5b8dda;
		border:solid 1px #848484;
		color:white;
	}
	div.slidepanel
	{
		height:75px;
		display:none;
	}
</style>
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
 
 function ListAdmins()
 {
 	  global $db;
	  $result = $db->Query("SELECT `user_id`, `username`, `level` FROM `bayonet_users` ORDER BY `level` DESC, `username` ASC");
	  $admins = $db->fetch($result);
	  
	  $num = 1;
	  OpenTable("300px");
	  echo "<tr><th></th><th style=\"text-align:left;\">Username</th><th style=\"text-align:left;\">Level</th></tr>";
	  foreach($admins as $admin)
	  {
	  	if($admin['level'] != $level){
	  		$level = $admin['level'];
	  		echo "<tr><td colspan=\"3\"><hr /></td></tr>";
  		}
	  	echo "<tr><td>{$num}.</td><td><a href=\"?op=admins&edit={$admin['user_id']}\">{$admin['username']}</a></td><td>{$admin['level']}</td></tr>";
	  	$num++;
	  }
	  CloseTable();
 }
 
 function NewAdmin()
 {
 	 
 	 global $db;
 	 $maxLevel = $_SESSION['level'];
 	 
 	 if(isset($_POST['processed'])){
 	 
 	 	$username = addslashes($_POST['username']);
		$email = addslashes($_POST['email']);
		$first = addslashes($_POST['first']);
		$last = addslashes($_POST['last']);
		
		$level = $_POST['level'];	
		$all = $_POST['all'];
		$squadleader = $_POST['squadleader'];
		$adjutant = $_POST['adjutant'];
		$quartermaster = $_POST['quartermaster'];
		
		$level = (int)$level;
		$all = (int)$all;
		$squadleader = (int)$squadleader;
		$adjutant = (int)$adjutant;
		$quartermaster = (int)$quartermaster;
				
		$password = GeneratePassword(8);		
		$cryptpassword = crypt(md5($password),'iamnotadirtywhorebitch');
			
		if(empty($username))
		{
			ReportError("This user must have a username to continue.");
			return;
		}
		
		$result = $db->Query("SELECT `level` FROM `bayonet_users` WHERE `username` = '$username' OR `email` = '$email'");
		if($db->Rows($result) > 0){
			ReportError("The email and or username you entered is already in use.");
			return;
		}
		
		
		$Name = "Rocky the Marne Dog";
		$subject = "3rd ID Admin Password";
		$header = "From: ". $Name . " < DO NOT RESPOND >\r\n"; //optional headerfields 
		$mail_body = "Do not respond to this email.\n\n------------------------------\nUsername: ".$username."\nPassword: ".$password."\n------------------------------\n\nTo login click on this link. http://testbed.3rd-infantry-division.org/cms/admin/ \n\nIt is recommended that you change your password once you login. To do so, click on Account Settings>Change Password.";
		
		$sent = mail($email, $subject, $mail_body, $header);
		if(!$sent){
			ReportError("Error validating email. This user was not saved.");
			return;		
		} 
				
		$db->Query("INSERT INTO `bayonet_users` (`user_id` ,`username` ,`password` ,`lastname` ,`firstname` ,`email` ,`joined` ,`level` ,`all` ,`squadleader` ,`adjutant` ,`quartermaster`) VALUES (NULL, '$username', '$cryptpassword', '$last', '$first', '$email', CURRENT_TIMESTAMP, $level, $all, $squadleader, $adjutant, $quartermaster)");
									
   		echo "Admin, '$username' level '$level' has been added. An email has been sent to him with his username and password.\n <br /><br /> 
			Please wait while you are redirected. <br /><br /> 
			<a href=\"?op=admins\">Click here if you don't feel like waiting.</a>";
					
	    // 3 second redirect to go back to the edit page
   		PageRedirect(2, "?op=admins");
	    return;
 	 }
?>
<div style="text-align:right"><img src="images/cancel.png" />Cancel</div>
<center>
		<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
		<table>
			<tr><th>Username:</th><td><input type="text" value="" name="username" />*</td></tr>
			<tr><th>First Name:</th><td><input type="text" value="" name="first" /></td></tr>
			<tr><th>Last Name:</th><td><input type="text" value="" name="last" /></td></tr>
			<tr><th>Email Address:</th><td><input type="text" value="" name="email" />*</td></tr>
			<tr>
				<th>Level:</th>
				<td>
					<select name="level">
					<?php 
						for($x=$maxLevel; $x>0;$x--){
							echo "<option value=\"{$x}\">{$x}</option>";						
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" name="processed" value="Submit" />
				</td>
			</tr>
		</table>
		<br />
		<?php GetPermissions(); ?>
		</form>
</center>
<?php
 }
 
 function GetPermissions($user = NULL)
 {
 ?>
 		<div class="slidepanel">
			<table width="100%" style="text-align:center;">
				<tr><th>Everything else</th><th>Squad Leader</th><th>Adjutant</th><th>Quartermaster</th></tr>
				<tr>
					<td width="25%">
						<input type="hidden" name="all" value="0" />
					<?php
						if(isset($user['all']) && $user['all'] == 1)
							echo "<input type=\"checkbox\" name=\"all\" value=\"1\" checked/>";
						else
							echo "<input type=\"checkbox\" name=\"all\" value=\"1\" />";
					?>
					</td>
					<td width="25%">
						<input type="hidden" name="squadleader" value="0" />
					<?php
						if(isset($user['squadleader']) && $user['squadleader'] == 1)
							echo "<input type=\"checkbox\" name=\"squadleader\" value=\"1\" checked/>";
						else
							echo "<input type=\"checkbox\" name=\"squadleader\" value=\"1\" />";
					?>
					</td>
					<td width="25%">
						<input type="hidden" name="adjutant" value="0" />
					<?php
						if(isset($user['adjutant']) && $user['adjutant'] == 1)
							echo "<input type=\"checkbox\" name=\"adjutant\" value=\"1\" checked/>";
						else
							echo "<input type=\"checkbox\" name=\"adjutant\" value=\"1\" />";
					?>
					</td>
					<td width="25%">
						<input type="hidden" name="quartermaster" value="0" />
					<?php
						if(isset($user['quartermaster']) && $user['quartermaster'] == 1)
							echo "<input type=\"checkbox\" name=\"quartermaster\" value=\"1\" checked/>";
						else
							echo "<input type=\"checkbox\" name=\"quartermaster\" value=\"1\" />";
					?>
					</td>
				</tr>
			</table>
		</div>
 
		<p class="flip">Show/Hide Permissions</p> 
 <?php
 }
 
 function GeneratePassword($length)
 {
 	srand(date("s")); 
    $possible_charactors = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
    $string = ""; 
    while(strlen($string)<$length) { 
        $string .= substr($possible_charactors, rand()%(strlen($possible_charactors)),1); 
    } 
    return($string); 
 }
 
 function EditAdmin($user_id)
 {
		global $db;
		$maxLevel = $_SESSION['level'];
		
		if(isset($_POST['processed']))
		{
			$username = addslashes($_POST['username']);
			$level = addslashes($_POST['level']);
			
			$all = $_POST['all'];
			$squadleader = $_POST['squadleader'];
			$adjutant = $_POST['adjutant'];
			$quartermaster = $_POST['quartermaster'];
			
			if(empty($username))
		    {
		      echo "You must fill everything out before proceeding.";
		      return;
		    }
				
			$db->Query("UPDATE `bayonet_users` SET `username` = '$username', `level` = '$level', `all` = '$all', `squadleader` = '$squadleader', `adjutant` = '$adjutant', `quartermaster` = '$quartermaster' WHERE `user_id` = '$user_id' LIMIT 1");
		    
		    echo "Admin, '$username' level '$level' has been edited.\n <br /><br /> 
					Please wait while you are redirected. <br /><br /> 
					<a href=\"?op=admins\">Click here if you don't feel like waiting.</a>";
					
		    // 3 second redirect to go back to the edit page
    		PageRedirect(2, "?op=admins&edit={$user_id}");
		    return;
		}
		
		$result = $db->Query("SELECT * FROM `bayonet_users` WHERE `user_id` = '$user_id' LIMIT 1");
		$admin = $db->FetchRow($result);

  		if($maxLevel < $admin['level']){
  			ReportError("You do not have permission to access this user.");
	    	return;	    	
		}
?>
<center>
		Edit the attributes of this administrator.<br />
		<form method="POST" action="<?php $_SERVER['PHP_SELF']?>">
		<table>
			<tr><th>Username:</th><td><input type="text" value="<?php echo $admin['username']; ?>" name="username" /></td></tr>
			<tr>
				<th>Level:</th>
				<td>
					<select name="level">
					<?php 
						for($x=$maxLevel; $x>0;$x--){
							if($admin['level'] == $x)
								echo "<option value=\"{$x}\" selected>{$x}</option>";
							else
								echo "<option value=\"{$x}\">{$x}</option>";						
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center;">
					<input type="submit" name="processed" value="Submit" />
					<a href="?op=admins&delete=<?php echo $user_id; ?>"><input type="button" value="Delete Admin" /></a>
				</td>
			</tr>
		</table>
		<br />
		<?php GetPermissions($admin); ?>
		</form>
</center>
<?php		
 }
 
 function DeleteAdmin($user_id)
 {
	global $db;
	$maxLevel = $_SESSION['level'];
		  
	$result = $db->Query("SELECT `username` FROM `bayonet_users` WHERE `user_id` = '$user_id'");
	$admin = $db->Fetch($result);
		  
	if(isset($_POST['proceed']))
	{
		echo "Admin '{$admin['username']}', was deleted.";
		$db->Query("DELETE FROM `bayonet_users` WHERE `user_id` = '$user_id' LIMIT 1");
		PageRedirect(3,"?op=admins");
		return;
	}
	if(isset($_POST['cancel']))
	{
		echo "User cancelled deletion of admin: '{$admin['username']}'";
		PageRedirect(1,"?op=admins");
		return;
	}  
	?>
	<center>
	<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
	<table>
	<th>Are you SURE you want to delete the administrative user: '<?php echo $admin['username']?>'?</th>
	<tr><th><button name="proceed">Yes</button>&nbsp;&nbsp;&nbsp;<button name="cancel">No</button></th></tr>
	</table>
	</form>
	</center>
	<?php
 }
 ?>