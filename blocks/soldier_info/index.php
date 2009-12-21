<?php
if($_COOKIE['mybbuser'] != '')
{
		global $db;	
		$logged_in = 'true';	
		
		$username = stripslashes($_COOKIE['mybbuser']);
		$login_cookie = explode('_', $username);
		$result = $db->Query("SELECT `uid`, `username`, `unreadpms`, `totalpms`, `postnum`, `usergroup`, `additionalgroups` FROM `mybb_users` WHERE `uid` = '".$login_cookie['0']."' AND `loginkey` = '".$login_cookie['1']."'");
		$check_num = $db->Rows($result);
		if ($check_num != '1')
		{	
			$past = time() - 100; 
			$logged_in = '';
			setcookie('mybbuser', gone, $past); 
			header("location: index.php");		
		}
		while(($row = $db->Fetch($result))!==false)
		{
			$logged_uid = $row['uid'];
			$logged_username = $row['username'];
			$avatar_type = $row['avatartype'];
			$pm_unread = $row['unreadpms'];
			$pm_total = $row['totalpms'];
			$postnum = $row['postnum'];
			
			$main_usergroup = $row['usergroup'];
			$add_usergroup = $row['additionalgroups'];
					
			$add_usergroups= explode(',', $add_usergroup);	
		}
}
?>
	<center>

		Your IP: <?php echo $_SERVER['REMOTE_ADDR']; ?><br />
<?php				
		if ($logged_in == 'true'){
?>
			<!-- <img src="<?php echo $avatar; ?>" alt="<?php echo $logged_username; ?>"/><br /><br /> -->
			<?php echo $postnum;?> post(s)<br /><br />
			</center>
					
			Welcome, <?php echo $logged_username; ?> <a href="logout.php">Logout</a><br />
			<hr />
			Private Messages <br />
			Unread: <a href="forums/private.php"><?php echo $pm_unread; ?></a><br />
			Total: <a href="forums/private.php"><?php echo $pm_total; ?></a><br />
			<hr />
<?php
		}
		else{
?>
			Welcome Guest.<br /><br />
			
			<form method="POST" action="">
			<table>
				<tr><td><input type="text" name="username" /></td></tr>
				<tr><td><input type="password" name="password" /></td><td><input type="submit" value="Login" /></td></tr>
			</table>
			</form>
			
			</center>
<?php 
		}		
?>