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
	  $result = $db->Query("SELECT `user_id`, `username`, `level` FROM `bayonet_users` ORDER BY `level` DESC");
	  while(($rows = $db->fetch($result))!=false)
	  {
	    $admins[] = $rows;
	  } 
	  
	  $num = 1;
	  OpenTable("300px");
	  echo "<tr><th></th><th>Username</th><th>Level</th></tr>";
	  foreach($admins as $admin)
	  {
	  	echo "<tr><td>{$num}.</td><td><a href=\"?op=admins&edit={$admin['user_id']}\">{$admin['username']}</a></td><td>{$admin['level']}</td></tr>";
	  	$num++;
	  }
	  CloseTable();
 }
 
 function NewAdmin()
 {
 	 $maxLevel = $_SESSION['level'];
 }
 
 function EditAdmin($user_id)
 {
		global $db;
		$maxLevel = $_SESSION['level'];
		
		if(isset($_POST['processed']))
		{
			$username = addslashes($_POST['username']);
			$level = addslashes($_POST['level']);
			
			if(empty($username))
		    {
		      echo "You must fill everything out before proceeding.";
		      return;
		    }
				
			$db->Query("UPDATE `bayonet_users` SET `username` = '$username', `level` = '$level' WHERE `user_id` = '$user_id' LIMIT 1");
		    
		    echo "Admin, '$username' level '$level' has been edited.\n <br /><br /> 
					Please wait while you are redirected. <br /><br /> 
					<a href=\"?op=admins\">Click here if you don't feel like waiting.</a>";
					
		    // 3 second redirect to go back to the edit page
    		PageRedirect(3, "?op=admins");
		    return;
		}
		
		$result = $db->Query("SELECT * FROM `bayonet_users` WHERE `user_id` = '$user_id' LIMIT 1");
		while(($rows = $db->fetch($result))!=false)
		{
			$admin = $rows;
		} 	  
		
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
		PageRedirect(3,"?op=admins");
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