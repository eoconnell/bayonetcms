<?php
$avatar_path = '/cms/forums/avatars/';
require_once dirname(__FILE__) . '/../../forums/SSI.php';

//decho($GLOBALS['user_info']);


global $user_info;

$user   = $user_info;
$name = $user['name'];
$avatar = empty($user['avatar']['url']) ? 'blank.gif' : $user['avatar']['url'];
$ip = $user['ip'];
$posts = $user['posts'];
$messages = $user['messages'];
$unread_messages = $user['unread_messages'];

if(strstr($avatar,'http://'))
{
	$avatar_path = NULL;
}

if (isset($GLOBALS['ID_MEMBER']) && $GLOBALS['ID_MEMBER'] != 0): ?>
	<div>
		<p>
			<center>
				<b>Your IP:</b> <?php echo $ip; ?><br />
				<b>Total posts:</b> <?php echo $posts; ?><br />
			</center>
		</p>
		
		<p>
			Welcome, <?php echo $name; ?> (<?php ssi_logout('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']); ?>)<br />
			<b>Inbox:</b> <?php echo $messages; ?><br />
			<b>Unread:</b> <?php echo $unread_messages; ?><br />
		</p>
		
	</div>
	
<?php else: ?>
<?php ssi_login('http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']); ?>
<?php endif; ?>
