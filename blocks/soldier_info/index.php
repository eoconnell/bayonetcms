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
			//echo '<img src="'.$avatar.'" alt="'.$logged_username.'"/><br /><br />
			echo $postnum.' post(s)<br /><br />';
					echo '</center>
					

			Welcome, '.$logged_username.' <br />
			<a href="logout.php"><img src="images/arrow-blk.gif" border="0" alt="" />&nbsp;Logout</a><br />';
		}
		else{
			echo 'Welcome Guest.<br />
				</center>
				<br />';
		}						
		if ($logged_in == 'true'){					
			?>
			<hr />
			<!-- <img src="images/email-y.gif" /> -->Private Messages <br />
			<!-- <img src="images/email-r.gif" /> -->Unread: <a href="forums/private.php"><?php echo $pm_unread; ?></a><br />
			<!-- <img src="images/email-g.gif" /> -->Total: <a href="forums/private.php"><?php echo $pm_total; ?></a><br /><hr />
			<?php
		}
?>
	</center>