	<center>

		Your IP: <?php echo $_SERVER['REMOTE_ADDR']; ?><br />
<?php						
		if ($logged_in == 'true'){
			echo '<img src="'.$avatar.'" alt="'.$logged_username.'"/><br /><br />'.$postnum.' post(s)<br /><br />
					</center>
					

			Welcome, '.$logged_username.' <br />
			<a href="logout.php"><img src="images/arrow-blk.gif" border="0" alt="" />&nbsp;Logout</a><br />';
		}
		else{
			echo 'Welcome Guest.<br />
				</center>
				<br />';
		}						
		if ($logged_in == 'true'){					
				echo'<hr />
				<img src="images/email-y.gif" />Private Messages <br />
				<img src="images/email-r.gif" />Unread: <a href="forums/private.php">'.$pm_unread.'</a><br />
				<img src="images/email-g.gif" />Total: <a href="forums/private.php">'.$pm_total.'</a><br /><hr />';
		}
?>
	</center>